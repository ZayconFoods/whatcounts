<?php
	/**
	 * Created by PhpStorm.
	 * User: Tony DeStefano
	 * Date: 1/21/16
	 * Time: 1:48 PM
	 */

	namespace ZayconWhatCounts;

	/**
	 * Class WhatCounts
	 * @package ZayconWhatCounts
	 *
	 * @todo Pass function parameters by reference if it is going to be returned
	 * @todo Document which calls don't return well formed XML, and therefore need to be parsed as CSV.
	 */

	class WhatCounts
	{

		//const VERSION = '8.4.0';
		const VERSION = '';
		const DEFAULT_URL = 'https://api.whatcounts.com/bin/api_web';

		private $url;
		private $realm;
		private $password;
		private $version;

		/**
		 * WhatCounts constructor.
		 *
		 * @param null $realm
		 * @param null $password
		 * @param null $url
		 * @param null $version
		 */
		public function __construct($realm = NULL, $password = NULL, $url = NULL, $version = NULL)
		{
			$this
				->setRealm($realm)
				->setPassword($password)
				->setUrl(($url === NULL) ? self::DEFAULT_URL : $url)
				->setVersion(($version === NULL) ? self::VERSION : $version);
		}

		/**
		 * @return mixed
		 */
		public function getUrl()
		{
			return $this->url;
		}

		/**
		 * @param mixed $url
		 *
		 * @return WhatCounts
		 */
		public function setUrl($url)
		{
			$this->url = $url;

			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getRealm()
		{
			return $this->realm;
		}

		/**
		 * @param mixed $realm
		 *
		 * @return WhatCounts
		 */
		public function setRealm($realm)
		{
			$this->realm = $realm;

			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getPassword()
		{
			return $this->password;
		}

		/**
		 * @param mixed $password
		 *
		 * @return WhatCounts
		 */
		public function setPassword($password)
		{
			$this->password = $password;

			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getVersion()
		{
			return $this->version;
		}

		/**
		 * @param mixed $version
		 *
		 * @return WhatCounts
		 */
		public function setVersion($version)
		{
			$this->version = $version;

			return $this;
		}

		/**
		 * @return bool
		 * @throws Exception
		 */
		public function checkStatus()
		{
			if ($this->realm === NULL) {
				throw new Exception('You must set the realm before making a call');
			} elseif ($this->password === NULL) {
				throw new Exception('You must set the password before making a call');
			}

			return TRUE;
		}

		/**
		 * @param $command
		 * @param null $data
		 * @param string $format
		 *
		 * @return array|\SimpleXMLElement|string
		 * @throws Exception
		 */
		public function call($command, $data = NULL, $format = 'xml')
		{
			if ($this->checkStatus()) {
				$request = array(
					'form_params' => [
						'r'             => $this->realm,
						'p'             => $this->password,
						'version'       => $this->version,
						'c'             => $command,
						'output_format' => $format
					]
				);

				if (!empty($data)) {
					$request = array('form_params' => array_merge($request['form_params'], $data));
				}

				$guzzle = new \GuzzleHttp\Client;
				$response = $guzzle->request(
					'POST',
					$this->url,
					$request
				);

				$body = (string)$response->getBody();

				if (empty($body)) {
					throw new Exception("No results");
				}

				if ($body == 'Invalid credentials') {
					throw new Exception('Invalid Credentials');
				}

				if ((int)substr_compare($body, "FAILURE", 0, 7) == 0) {
					$result = explode(":", $body);
					throw new Exception(trim($result[1]));
				}

				if ((int)substr_compare($body, "SUCCESS", 0, 7) == 0) {
					$result = explode(":", $body);

					return $result;
				}

				if ((int)substr_compare($body, "<data>", 0, 6, 1) == 0) return new \SimpleXMLElement($body);
				if ((int)substr_compare($body, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>", 0, 38, 1) == 0) return new \SimpleXMLElement($body);

				return $body;
			}

			return FALSE;
		}

		/**
		 * @return Realm
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969879
		 */
		public function getRealmSettings()
		{
			$xml = $this->call('getrealmsettings');

			$realm = new Realm;
			$realm
				->setRealmId((int)$xml->Data->realm_id)
				->setUseCustomerKey((string)$xml->Data->use_customer_key)
				->setEnableRelationalDatabase((string)$xml->Data->enable_relational_database);

			return $realm;
		}

		/**
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669705
		 */
		public function showLists()
		{
			$form_data = array(
				'headers' => 1
			);
			$data = $this->call('show_lists', $form_data, 'csv');
			$csv = new \parseCSV($data);

			$lists = array();

			foreach ($csv->data as $listItem) {
				$list = new MailingList;
				$list
					->setListId((int)$listItem{'List Number'})// Whatcounts' show_lists command uses list_number instead of list_id
					->setListName((string)$listItem{'List Name'})
					->setDescription((string)$listItem{'List Description'})
					->setFolderId((int)$listItem{'Folder ID'});
				$lists[] = $list;
			}

			return $lists;
		}

		/**
		 * @param $list_id
		 *
		 * @return MailingList
		 *
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669715
		 */
		public function getListById($list_id)
		{
			$form_data = array(
				'list_id' => $list_id
			);
			$xml = $this->call('getlistbyid', $form_data);

			$list = new MailingList;
			$list
				->setListId((int)$xml->list_id)
				->setListName((string)$xml->list_name)
				->setDescription((string)$xml->description)
				->setTemplate((string)$xml->template)
				->setFromAddress((string)$xml->from)
				->setReplyToAddress((string)$xml->reply_to)
				->setBounceAddress((string)$xml->errors_to)
				->setTrackClicks((bool)$xml->track_clicks)
				->setTrackOpens((bool)$xml->track_opens)
				->setFolderId((int)$xml->folder_Id);

			return $list;
		}

		/**
		 * @param $list_name
		 *
		 * @return MailingList
		 *
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669715
		 */
		public function getListByName($list_name)
		{
			$form_data = array(
				'list_name' => $list_name
			);
			$xml = $this->call('getlistbyname', $form_data);

			$list = new MailingList;
			$list
				->setListId((int)$xml->list_id)
				->setListName((string)$xml->list_name)
				->setDescription((string)$xml->description)
				->setTemplate((string)$xml->template)
				->setFromAddress((string)$xml->from)
				->setReplyToAddress((string)$xml->reply_to)
				->setBounceAddress((string)$xml->errors_to)
				->setTrackClicks((bool)$xml->track_clicks)
				->setTrackOpens((bool)$xml->track_opens)
				->setFolderId((int)$xml->folder_Id);

			return $list;
		}

		/**
		 * @param MailingList $list
		 *
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969409
		 */
		public function exCreateList(MailingList &$list)
		{
			$form_data = array(
				'list_name'    => $list->getListName(),
				'description'  => $list->getDescription(),
				'template_id'  => $list->getTemplate(),
				'from'         => $list->getFromAddress(),
				'reply_to'     => $list->getReplyToAddress(),
				'errors_to'    => $list->getBounceAddress(),
				'track_clicks' => $list->isTrackClicks(),
				'track_opens'  => $list->isTrackOpens(),
				'folder_id'    => $list->getFolderId()
			);
			$data = $this->call('excreatelist', $form_data);

			$list->setListId(trim($data[1]));
		}

		/**
		 * @param MailingList $list
		 *
		 * @return bool
		 *
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969409
		 */
		public function createList(MailingList $list)
		{
			$form_data = array(
				'list_name'    => $list->getListName(),
				'description'  => $list->getDescription(),
				'template_id'  => $list->getTemplate(),
				'from'         => $list->getFromAddress(),
				'reply_to'     => $list->getReplyToAddress(),
				'errors_to'    => $list->getBounceAddress(),
				'track_clicks' => $list->isTrackClicks(),
				'track_opens'  => $list->isTrackOpens(),
				'folder_id'    => $list->getFolderId()
			);
			$this->call('createlist', $form_data);

			return TRUE;
		}

		/**
		 * @param MailingList $list
		 *
		 * @return bool
		 *
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969419
		 */
		public function updateList(MailingList $list)
		{
			$form_data = array(
				'list_id'      => $list->getListId(),
				'list_name'    => $list->getListName(),
				'description'  => $list->getDescription(),
				'template_id'  => $list->getTemplate(),
				'from'         => $list->getFromAddress(),
				'reply_to'     => $list->getReplyToAddress(),
				'errors_to'    => $list->getBounceAddress(),
				'track_clicks' => $list->isTrackClicks(),
				'track_opens'  => $list->isTrackOpens(),
				'folder_id'    => $list->getFolderId()
			);
			$this->call('updatelist', $form_data);

			return TRUE;
		}

		/**
		 * @param Subscriber $subscriber
		 * @param bool $exact_match
		 *
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669925
		 */
		public function findSubscribers(Subscriber $subscriber, $exact_match = FALSE)
		{
			$form_data = array(
				'email' => $subscriber->getEmail(),
				'first' => $subscriber->getFirstName(),
				'last'  => $subscriber->getLastName(),
				'exact' => (int)$exact_match,
			);
			$xml = $this->call('find', $form_data);

			$subscribers = array();

			foreach ($xml->subscriber as $subscriberItem) {
				$subscriber = new Subscriber;
				$subscriber
					->setListCount((int)$subscriberItem->lists)
					->setEmail((string)$subscriberItem->email)
					->setFirstName((string)$subscriberItem->first)
					->setLastName((string)$subscriberItem->last)
					->setSubscriberId((int)$subscriberItem->subscriber_id);
				$subscribers[] = $subscriber;
			}

			return $subscribers;
		}

		/**
		 * @param Subscriber $subscriber
		 * @param null $list_id
		 * @param bool $exact_match
		 *
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969649
		 */
		public function findSubscriberInList(Subscriber $subscriber, $list_id = NULL, $exact_match = FALSE)
		{
			$form_data = array(
				'email'   => $subscriber->getEmail(),
				'first'   => $subscriber->getFirstName(),
				'last'    => $subscriber->getLastName(),
				'list_id' => $list_id,
				'exact'   => (int)$exact_match,
			);
			$xml = $this->call('findinlist', $form_data);

			$subscribers = array();

			foreach ($xml->subscriber as $subscriberItem) {
				$subscriber = new Subscriber;
				$subscriber
					->setListCount((int)$subscriberItem->lists)
					->setEmail((string)$subscriberItem->email)
					->setFirstName((string)$subscriberItem->first)
					->setLastName((string)$subscriberItem->last)
					->setSubscriberId((int)$subscriberItem->subscriber_id);
				$subscribers[] = $subscriber;
			}

			return $subscribers;
		}

		/**
		 * @param Subscriber $subscriber
		 *
		 * @return Subscriber
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969609
		 *
		 */
		public function subscribe(Subscriber $subscriber)
		{
			$form_data = array(
				'list_id'               => $subscriber->getListId(),
				'format'                => $subscriber->getFormat(),
				'force_sub'             => $subscriber->isForceSub(),
				'override_confirmation' => $subscriber->isOverrideConfirmation(),
				'data'                  => 'email,first,last,address_1,address_2,city,state,zip,country,phone,fax,company^'
					. $subscriber->getEmail() . ','
					. $subscriber->getFirstName() . ','
					. $subscriber->getLastName() . ','
					. $subscriber->getAddress1() . ','
					. $subscriber->getAddress2() . ','
					. $subscriber->getCity() . ','
					. $subscriber->getState() . ','
					. $subscriber->getZip() . ','
					. $subscriber->getCountry() . ','
					. $subscriber->getPhone() . ','
					. $subscriber->getFax() . ','
					. $subscriber->getCompany()
			);
			$xml = $this->call('sub', $form_data);

			return trim($xml[1]);
		}

		/**
		 * @param Subscriber $subscriber
		 * @param $list_id
		 * @param bool $force_optout
		 *
		 * @return string
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969639
		 *
		 */
		public function unsubscribe(Subscriber $subscriber, $list_id, $force_optout = FALSE)
		{
			$form_data = array(
				'list_id'      => $list_id,
				'force_optout' => $force_optout,
				'data'         => 'email,first,last^'
					. $subscriber->getEmail() . ','
					. $subscriber->getFirstName() . ','
					. $subscriber->getLastName()
			);
			$xml = $this->call('unsub', $form_data);

			return trim($xml[1]);
		}

		/**
		 * @param Subscriber $subscriber
		 *
		 * @return string
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669915
		 *
		 */
		public function deleteSubscriber(Subscriber $subscriber)
		{
			$form_data = array(
				'data' => 'email^' . $subscriber->getEmail()
			);
			$xml = $this->call('delete', $form_data);

			return trim($xml[1]);
		}

		/**
		 * @param array $subscribers
		 *
		 * @return string
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669915
		 */
		public function deleteSubscribers(Array $subscribers)
		{
			$form_data = array(
				'data' => 'email^' . implode("^", $subscribers)
			);

			$xml = $this->call('delete', $form_data);

			return trim($xml[1]);
		}

		/**
		 * @param $subscriber_id
		 *
		 * @return Subscriber
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969659
		 */
		public function showSubscriber($subscriber_id)
		{
			$form_data = array(
				'subscriber_id' => $subscriber_id
			);
			$xml = $this->call('detail', $form_data);
			$subscriber_data = $xml->subscriber;

			$subscriber = new Subscriber;
			$subscriber
				->setSubscriberId((int)$subscriber_data->subscriber_id)
				->setEmail((string)$subscriber_data->email)
				->setFirstName((string)$subscriber_data->first)
				->setLastName((string)$subscriber_data->last)
				->setCompany((string)$subscriber_data->company)
				->setAddress1((string)$subscriber_data->address_1)
				->setAddress2((string)$subscriber_data->address_2)
				->setCity((string)$subscriber_data->city)
				->setState((string)$subscriber_data->state)
				->setZip((string)$subscriber_data->zip)
				->setCountry((string)$subscriber_data->country)
				->setPhone((string)$subscriber_data->phone)
				->setFax((string)$subscriber_data->fax);

			$list_ids = (array)explode(",", $subscriber_data->lists);
			$subscriber_lists = array();
			$subscription_details = $subscriber_data->subscription_details;

			foreach ($list_ids as $list_id) {
				$subscriber_list = New SubscriberList;
				$subscriber_list
					->setListId((int)$list_id)
					->setCreatedDate(date_create_from_format('d/m/y h:i A', $subscription_details->{'list_' . $list_id}->created_date))
					->setLastSent(date_create_from_format('d/m/y h:i A', $subscription_details->{'list_' . $list_id}->last_sent))
					->setSentFlag($subscription_details->{'list_' . $list_id}->sent_flag)
					->setFormat($subscription_details->{'list_' . $list_id}->format);
				$subscriber_lists[] = $subscriber_list;
			}
			$subscriber->setLists($subscriber_lists);

			return $subscriber;
		}

		/**
		 * @param Subscriber $subscriber
		 *
		 * @return string
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969619
		 *
		 */
		public function updateSubscriber(Subscriber $subscriber)
		{
			$form_data = array(
				'list_id'        => $subscriber->getListId(),
				'identity_field' => 'email',
				'data'           => 'email,first,last,address_1,address_2,city,state,zip,country,phone,fax,company^'
					. $subscriber->getEmail() . ','
					. $subscriber->getFirstName() . ','
					. $subscriber->getLastName() . ','
					. $subscriber->getAddress1() . ','
					. $subscriber->getAddress2() . ','
					. $subscriber->getCity() . ','
					. $subscriber->getState() . ','
					. $subscriber->getZip() . ','
					. $subscriber->getCountry() . ','
					. $subscriber->getPhone() . ','
					. $subscriber->getFax() . ','
					. $subscriber->getCompany()
			);
			$xml = $this->call('update', $form_data);

			return trim($xml[1]);
		}

		/**
		 * @param Subscriber $subscriber
		 * @param $new_email
		 *
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969629
		 */
		public function changeEmailAddress(Subscriber &$subscriber, $new_email)
		{
			$form_data = array(
				'email'     => $subscriber->getEmail(),
				'email_new' => $new_email
			);
			$this->call('change', $form_data);

			$subscriber->setEmail($new_email);
		}

		/**
		 * @param Subscriber $subscriber
		 * @param $lc_campaign_name
		 *
		 * @return string
		 * @throws Exception
		 *
		 * API documentation: https://support.whatcounts.com/hc/en-us/articles/203969779
		 */
		public function addSubscriberToLifecycleCampaign(Subscriber $subscriber, $lc_campaign_name)
		{
			$form_data = array(
				'lc_campaign_name' => $lc_campaign_name,
				'data'             => 'email,first^'
					. $subscriber->getEmail() . ','
					. $subscriber->getFirstName() . ','
			);
			$xml = $this->call('addtolifecyclecampaign', $form_data);

			return trim($xml[1]);
		}

		/**
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969439
		 *
		 * @todo Create test in examples/
		 */
		public function showSegmentationRules()
		{
			$form_data = array(
				'headers' => 1
			);
			$data = $this->call('show_seg', $form_data, 'csv');
			$csv = new \parseCSV($data);

			$rules = array();

			foreach ($csv->data as $ruleItem) {
				$rule = new SegmentationRule;
				$rule->setListId($ruleItem->list_id);
				$rules[] = $rule;
			}

			return $rules;
		}

		/**
		 * @param SegmentationRule $segmentation_rule
		 *
		 * @return SegmentationRule
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669735
		 *
		 * @todo Populate $form_data with relevant fields from $segmentation_rule
		 * @todo Create test in examples/
		 */
		public function createSegmentationRule(SegmentationRule $segmentation_rule)
		{
			$form_data = array();
			$xml = $this->call('createseg', $form_data);

			return $segmentation_rule;
		}

		/**
		 * @param SegmentationRule $segmentation_rule
		 *
		 * @return SegmentationRule
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669745
		 *
		 * @todo Populate $form_data with relevant fields from $segmentation_rule
		 * @todo Create test in examples/
		 */
		public function updateSegmentationRule(SegmentationRule &$segmentation_rule)
		{
			$form_data = array();
			$xml = $this->call('updateseg', $form_data);
		}

		/**
		 * @param SegmentationRule $segmentation_rule
		 *
		 * @return SegmentationRule
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969459
		 *
		 * @todo Populate $form_data with relevant fields from $segmentation_rule
		 * @todo Create test in examples/
		 */
		public function deleteSegmentationRule(SegmentationRule $segmentation_rule)
		{
			$form_data = array();
			$xml = $this->call('deleteseg', $form_data);

			return $segmentation_rule;
		}

		/**
		 * @param SegmentationRule $segmentation_rule
		 *
		 * @return mixed
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969449
		 *
		 * @todo Populate $form_data with relevant fields from $segmentation_rule
		 * @todo Create test in examples/
		 */
		public function testSegmentationRule(SegmentationRule $segmentation_rule)
		{
			$form_data = array();
			$xml = $this->call('testseg', $form_data);

			return $segmentation_rule;
		}

		/**
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969479
		 *
		 * @todo Create test in examples/
		 */
		public function showTemplates()
		{
			$form_data = array(
				'headers' => 1
			);
			$data = $this->call('show_templates', $form_data, 'csv');
			$csv = new \parseCSV($data);

			$templates = array();

			foreach ($csv->data as $template_item) {
				$template = new Template;
				$templates[] = $template;
			}

			return $templates;
		}

		/**
		 * @param $template_id
		 *
		 * @return Template
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969489
		 *
		 * @todo Create test in examples/
		 */
		public function getTemplateById($template_id)
		{
			$form_data = array(
				'template_id' => $template_id
			);
			$xml = $this->call('gettemplatebyid', $form_data);

			$template = new Template;

			return $template;
		}

		/**
		 * @param $template_name
		 *
		 * @return Template
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969489
		 *
		 * @todo Create test in examples/
		 */
		public function getTemplateByName($template_name)
		{
			$form_data = array(
				'template_name' => $template_name
			);
			$xml = $this->call('gettemplatebyname', $form_data);

			$template = new Template;

			return $template;
		}

		/**
		 * @param Template $template
		 *
		 * @return Template
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969469
		 *
		 * @todo Populate $form_data with relevant fields from $template
		 * @todo Create test in examples/
		 */
		public function createTemplate(Template $template)
		{
			$form_data = array();
			$data = $this->call('createtemplate', $form_data);

			return $template;
		}

		/**
		 * @param Template $template
		 *
		 * @return Template
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669765
		 *
		 * @todo Populate $form_data with relevant fields from $template
		 * @todo Create test in examples/
		 */
		public function updateTemplate(Template $template)
		{
			$form_data = array();
			$data = $this->call('updatetemplate', $form_data);

			return $template;
		}

		/**
		 * @param Template $template
		 *
		 * @return Template
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669775
		 *
		 * @todo Populate $form_data with relevant fields from $template
		 * @todo Create test in examples/
		 */
		public function previewTemplate(Template $template)
		{
			$form_data = array();
			$data = $this->call('templatepreview', $form_data);

			return $template;
		}

		/**
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969509
		 *
		 * @todo Create test in examples/
		 */
		public function showArticles()
		{
			$form_data = array(
				'headers' => 1
			);
			$data = $this->call('showarticlelist', $form_data, 'csv');
			$csv = new \parseCSV($data);

			$articles = array();

			foreach ($csv->data as $article_item) {
				$article = new Article;
				$articles[] = $article;
			}

			return $articles;
		}

		/**
		 * @param $article_id
		 *
		 * @return Article
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669805
		 *
		 * @todo Create test in examples/
		 */
		public function getArticleById($article_id)
		{
			$form_data = array(
				'article_id' => $article_id
			);
			$xml = $this->call('getarticlewithid', $form_data);

			$article = new Article;

			return $article;
		}

		/**
		 * @param $article_name
		 *
		 * @return Article
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669805
		 *
		 * @todo Create test in examples/
		 */
		public function getArticleByName($article_name)
		{
			$form_data = array(
				'article_name' => $article_name
			);
			$xml = $this->call('getarticlewithname', $form_data);

			$article = new Article;

			return $article;
		}

		/**
		 * @param $article_name
		 *
		 * @return Article
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669815
		 *
		 * @todo Create test in examples/
		 * @todo Do we need to pass in an Article object?
		 */
		public function copyArticle($article_name)
		{
			$form_data = array(
				'article_name' => $article_name
			);
			$xml = $this->call('getarticlewithname', $form_data);

			$article = new Article;

			return $article;
		}

		/**
		 * @param Article $article
		 *
		 * @return Article
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969499
		 *
		 * @todo Populate $form_data with relevant fields from $article
		 * @todo Create test in examples/
		 */
		public function createBlankArticle(Article $article)
		{
			$form_data = array();
			$data = $this->call('createblankarticle', $form_data);

			return $article;
		}

		/**
		 * @param Article $article
		 *
		 * @return Article
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969499
		 *
		 * @todo Populate $form_data with relevant fields from $article
		 * @todo Create test in examples/
		 */
		public function createArticle(Article $article)
		{
			$form_data = array();
			$data = $this->call('createarticle', $form_data);

			return $article;
		}

		/**
		 * @param Article $article
		 *
		 * @return Article
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969519
		 *
		 * @todo Populate $form_data with relevant fields from $article
		 * @todo Create test in examples/
		 */
		public function updateArticle(Article $article)
		{
			$form_data = array();
			$data = $this->call('updatearticle', $form_data);

			return $article;
		}

		/**
		 * @param Article $article
		 *
		 * @return Article
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969529
		 *
		 * @todo Populate $form_data with relevant fields from $article
		 * @todo Create test in examples/
		 */
		public function deleteArticle(Article $article)
		{
			$form_data = array();
			$data = $this->call('deletearticle', $form_data);

			return $article;
		}

		/**
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670035
		 *
		 * @todo Populate $ab_test with fields from $ab_test_item
		 * @todo Create test in examples/
		 */
		public function showABDefinitions()
		{
			$xml = $this->call('show_abdefinitions');

			$ab_tests = array();

			foreach ($xml->data as $ab_test_item) {
				$ab_test = new ABTest;
				$ab_tests[] = $ab_test;
			}

			return $ab_tests;
		}

		/**
		 * @param $ab_definition_id
		 *
		 * @return ABTest
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969789
		 *
		 * @todo Populate $ab_test with fields from $xml
		 * @todo Create test in examples/
		 */
		public function getABDefinition($ab_definition_id)
		{
			$form_data = array(
				'ab_definition_id' => $ab_definition_id
			);
			$xml = $this->call('getabdefinitionbyid', $form_data);

			$ab_test = new ABTest;

			return $ab_test;
		}

		/**
		 * @param $ab_definition_id
		 *
		 * @return ABTestStatistics
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670045
		 *
		 * @todo Populate $ab_test_statistics with fields from $xml
		 * @todo Create test in examples/
		 */
		public function reportABTestStatistics($ab_definition_id)
		{
			$form_data = array(
				'ab_definition_id' => $ab_definition_id
			);
			$xml = $this->call('rpt_abstats', $form_data);

			$ab_test_statistics = new ABTestStatistics;

			return $ab_test_statistics;
		}

		/**
		 * @param $ab_definition_id
		 *
		 * @return bool
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670055
		 *
		 * @todo Find out how to get $ab_definition_id
		 * @todo Create test in examples/
		 */
		public function chooseABWinner($ab_definition_id)
		{
			$form_data = array(
				'ab_definition_id' => $ab_definition_id
			);
			$xml = $this->call('abmailwinner', $form_data);

			$ab_test_statistics = new ABTestStatistics;

			return TRUE;
		}

		/**
		 * @param Field $field
		 *
		 * @return Field
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669835
		 *
		 * @todo Populate $form_data with relevant fields from $field
		 * @todo Create test in examples/
		 */
		public function createCustomField(Field $field)
		{
			$form_data = array();
			$data = $this->call('customfieldcreate', $form_data);

			return $field;
		}

		/**
		 * @param Field $field
		 *
		 * @return Field
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669845
		 *
		 * @todo Populate $form_data with relevant fields from $field
		 * @todo Create test in examples/
		 */
		public function deleteCustomField(Field $field)
		{
			$form_data = array();
			$data = $this->call('customfielddelete', $form_data);

			return TRUE;
		}

		/**
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969549
		 *
		 * @todo Populate $social_provider with relevant fields from $social_provider_item
		 * @todo Create test in examples/
		 */
		public function getSocialProviders()
		{
			$xml = $this->call('getsocialproviders');

			$social_providers = array();

			foreach ($xml->data as $social_provider_item) {
				$social_provider = new SocialProvider;
				$social_providers[] = $social_provider;
			}

			return $social_providers;
		}

		/**
		 * @param $social_provider_id
		 *
		 * @return SocialProvider
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669885
		 *
		 * @todo Populate $social_provider with relevant fields from $xml
		 * @todo Create test in examples/
		 */
		public function getSocialProviderById($social_provider_id)
		{
			$form_data = array(
				'social_provider_id' => $social_provider_id
			);
			$xml = $this->call('getsocialproviderbyid', $form_data);

			$social_provider = new SocialProvider;

			return $social_provider;

		}

		/**
		 * @param SocialProvider $social_provider
		 *
		 * @return SocialProvider
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969559
		 *
		 * @todo Create test in examples/
		 */
		public function getSocialProviderByUserName(SocialProvider $social_provider)
		{
			$form_data = array(
				'social_provider_name' => $social_provider->getProviderName(),
				'username'             => $social_provider->getUsername()
			);
			$xml = $this->call('getsocialproviderbyusername', $form_data);

			$social_provider
				->setProviderId((int)$xml->data->provider_id);

			return $social_provider;
		}

		/**
		 * @param SocialProvider $social_provider
		 *
		 * @return bool
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969569
		 *
		 * @todo Create test in examples/
		 */
		public function deleteSocialProviderById(SocialProvider $social_provider)
		{
			$form_data = array(
				'social_provider_id' => $social_provider->getProviderId()
			);
			$xml = $this->call('deletesocialproviderbyid', $form_data);

			return TRUE;
		}

		/**
		 * @param SocialProvider $social_provider
		 *
		 * @return bool
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969579
		 *
		 * @todo Create test in examples/
		 */
		public function deleteSocialProviderByUserName(SocialProvider $social_provider)
		{
			$form_data = array(
				'social_provider_name' => $social_provider->getProviderName(),
				'username'             => $social_provider->getUsername()
			);
			$xml = $this->call('deletesocialproviderbyusername', $form_data);

			return TRUE;
		}

		/**
		 * @param Template $template
		 * @param SocialProvider $social_provider
		 *
		 * @return bool
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969589
		 *
		 * @todo Populate $form_data with relevant fields from $template and $social_provider
		 * @todo Create test in examples/
		 */
		public function setSocialPostForTemplate(Template $template, SocialProvider $social_provider)
		{
			$form_data = array();
			$xml = $this->call('setsocialpostfortemplate', $form_data);

			return TRUE;
		}

		/**
		 * @param Template $template
		 *
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969599
		 *
		 * @todo Populate $social_post with relevant fields from $social_post_item
		 * @todo Create test in examples/
		 */
		public function getSocialPostsByTemplateId(Template $template)
		{
			$form_data = array(
				'template_id' => $template->getTemplateId()
			);
			$xml = $this->call('getsocialpostsfortemplatebyid', $form_data);

			$social_posts = array();

			foreach ($xml->data as $social_post_item) {
				$social_post = new SocialPost();
				$social_posts[] = $social_post;
			}

			return $social_posts;
		}

		/**
		 * @param Template $template
		 *
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669895
		 *
		 * @todo Create test in examples/
		 */
		public function getSocialPostsByTemplateName(Template $template)
		{
			$form_data = array(
				'template_name' => $template->getTemplateName()
			);
			$xml = $this->call('getsocialpostsfortemplatebyname', $form_data);

			$social_posts = array();

			foreach ($xml->data as $social_post_item) {
				$social_post = new SocialPost();
				$social_posts[] = $social_post;
			}

			return $social_posts;
		}

		/**
		 * @param Mail $message
		 *
		 * @return string
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969749
		 */
		public function sendOneOffMessage(Mail $message)
		{
			$form_data = array(
				'list_id' => $message->getListId(),
				'from' => $message->getFromAddress(),
				'reply_to_address' => $message->getReplyToAddress(),
				'errors_to' => $message->getBounceAddress(),
				'sender' => $message->getSenderAddress(),
				'to' => $message->getSendToAddress(),
				'cc' => $message->getCcToAddress(),
				'template_id' => $message->getTemplateId(),
				'plain_text_body' => $message->getBodyText(),
				'html_body' => $message->getBodyHtml(),
				'subject' => $message->getSubject(),
				'format' => $message->getFormat(),
				'campaign_name' => $message->getCampaignName(),
				'vmta' => $message->getVirtualMta(),
				'first_name' => $message->getFirstName(),
				'dup' => $message->isDuplicate(),
				'ignore_optout' => $message->isIgnoreOptout(),
				'charset' => $message->getCharacterEncoding(),
				'data' => $message->getData(),
			);
			$xml = $this->call('send', $form_data);

			return trim($xml[1]);
		}

		/**
		 * @param Mail $message
		 *
		 * @return string
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669975
		 */
		public function subscribeAndSendOneOffMessage(Mail $message)
		{
			$form_data = array(
				'list_id' => $message->getListId(),
				'from' => $message->getFromAddress(),
				'reply_to_address' => $message->getReplyToAddress(),
				'errors_to' => $message->getBounceAddress(),
				'sender' => $message->getSenderAddress(),
				'to' => $message->getSendToAddress(),
				'cc' => $message->getCcToAddress(),
				'template_id' => $message->getTemplateId(),
				'plain_text_body' => $message->getBodyText(),
				'html_body' => $message->getBodyHtml(),
				'subject' => $message->getSubject(),
				'format' => $message->getFormat(),
				'campaign_name' => $message->getCampaignName(),
				'vmta' => $message->getVirtualMta(),
				'first_name' => $message->getFirstName(),
				'dup' => $message->isDuplicate(),
				'ignore_optout' => $message->isIgnoreOptout(),
				'charset' => $message->getCharacterEncoding(),
				'data' => $message->getData(),
			);
			$xml = $this->call('subandsend', $form_data);

			return trim($xml[1]);
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669985
		 */
		public function launchCampaign()
		{
			$form_data = array();
			$xml = $this->call('launch', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669995
		 */
		public function scheduleCampaign()
		{
			$form_data = array();
			$xml = $this->call('schedule_deployment', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670005
		 */
		public function processSpringbotAbandonedCart()
		{
			$form_data = array();
			$xml = $this->call('springbot_process_abandoned_cart', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969759
		 */
		public function showCampaigns()
		{
			$form_data = array();
			$xml = $this->call('show_campaigns', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969769
		 */
		public function reportCampaignList()
		{
			$form_data = array();
			$xml = $this->call('rpt_campaign_list', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969799
		 */
		public function showCampaignStatistics()
		{
			$form_data = array();
			$xml = $this->call('', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969809
		 */
		public function showMultipleCampaginStatistics()
		{
			$form_data = array();
			$xml = $this->call('show_campaign_stats', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://support.whatcounts.com/hc/en-us/articles/204670075
		 */
		public function reportCampaignClicks()
		{
			$form_data = array();
			$xml = $this->call('rpt_click_overview', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670085
		 */
		public function reportSubscriberClicks()
		{
			$form_data = array();
			$xml = $this->call('rpt_clicked_on', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670095
		 */
		public function reportDailyStatistics()
		{
			$form_data = array();
			$xml = $this->call('rpt_daily_stats', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969819
		 */
		public function reportBrowserInfo()
		{
			$form_data = array();
			$xml = $this->call('rpt_browser_info', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670105
		 */
		public function reportBounceStatistics()
		{
			$form_data = array();
			$xml = $this->call('rpt_bounce_stats', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969829
		 */
		public function reportTrackedEvents()
		{
			$form_data = array();
			$xml = $this->call('rpt_tracked_events', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969839
		 */
		public function reportTrackedEventsByCampaign()
		{
			$form_data = array();
			$xml = $this->call('rpt_tracked_events_by_campaign', $form_data);

			return $xml;
		}

		/**
		 * @param Subscriber $subscriber
		 *
		 * @return array
		 * @throws Exception
		 *
 		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969849
		 */
		public function showUserEvents(Subscriber $subscriber)
		{
			$form_data = array(
				'subscriber_id' => $subscriber->getSubscriberId(),
				'headers' => 1
			);
			$data = $this->call('show_user_events', $form_data, 'csv');
			$csv = new \parseCSV($data);

			$reports = array();

			foreach ($csv->data as $reportItem) {
				$report = new Report;
				$report
					->setEventName((string)$reportItem{'Event'})
					->setEventId((int)$reportItem{'Event ID'})
					->setListName((string)$reportItem{'List'})
					->setListId((int)$reportItem{'List ID'})
					->setDate(date_create_from_format('d/m/y h:i A', $reportItem{'Date'}));
				$reports[] = $report;
			}

			return $reports;
		}

		/**
		 * @param Subscriber $subscriber
		 * @param null $event_type
		 *
		 * @return array|\SimpleXMLElement|string
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670115
		 */
		public function reportSubscriberEvents(Subscriber $subscriber, $event_type = NULL)
		{
			$form_data = array(
				'subscriber_id' => $subscriber->getSubscriberId(),
				'event_type' => $event_type,

			);
			$xml = $this->call('rpt_subscriber_events', $form_data);

			$reports = array();

			foreach ($xml->Data as $reportItem) {
				$report = new Report;
				$report
					->setEventName((string)$reportItem->event)
					->setEventId((int)$reportItem->event_id)
					->setListName((string)$reportItem->list)
					->setListId((int)$reportItem->list_id)
					->setDate(date_create_from_format('d/m/y h:i A', $reportItem->date));
				$reports[] = $report;
			}

			return $reports;
		}

		/**
		 * @param null $list_id
		 * @param null $campaign_id
		 *
		 * @return array|\SimpleXMLElement|string
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670125
		 */
		public function reportUnsubscribes($list_id = NULL, $campaign_id = NULL)
		{
			$form_data = array(
				'list_id' => $list_id,
				'campaign_id' => $campaign_id
			);
			$xml = $this->call('rpt_unsubscribe', $form_data);

			return $xml;
		}

		/**
		 * @param $list_id
		 * @param int $days
		 *
		 * @return array|\SimpleXMLElement|string
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670135
		 */

		public function showOptouts($list_id, $days = 30)
		{
			$form_data = array(
				'list_id' => $list_id,
				'days' => $days
			);
			$xml = $this->call('show_optout', $form_data);

			return $xml;
		}

		/**
		 * @param int $days
		 *
		 * @return array|\SimpleXMLElement|string
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969859
		 */
		public function showGlobalOptouts($days = 30)
		{
			$form_data = array(
				'days' => $days
			);
			$xml = $this->call('show_optglobal', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670145
		 */
		public function showHardBounces()
		{
			$form_data = array();
			$xml = $this->call('', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670155
		 */
		public function showSoftBounces()
		{
			$form_data = array();
			$xml = $this->call('', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969869
		 */
		public function showBlockBounces()
		{
			$form_data = array();
			$xml = $this->call('', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670165
		 */
		public function showComplaints()
		{
			$form_data = array();
			$xml = $this->call('', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969669
		 */
		public function reportSubscriberByUpdate()
		{
			$form_data = array();
			$xml = $this->call('', $form_data);

			return $xml;
		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969429
		 */
		public function reportSubscribersInList()
		{
			$form_data = array();
			$xml = $this->call('', $form_data);

			return $xml;
		}
	}

