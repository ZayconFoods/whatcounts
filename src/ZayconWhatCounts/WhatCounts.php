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
					->setCreatedDate(date_create_from_format('m/d/y h:i A', $subscription_details->{'list_' . $list_id}->created_date))
					->setLastSent(date_create_from_format('m/d/y h:i A', $subscription_details->{'list_' . $list_id}->last_sent))
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
		 */
		public function showSegmentationRules()
		{
			$form_data = array(
				'headers' => 1
			);
			$data = $this->call('show_seg', $form_data, 'csv');
			$csv = new \parseCSV($data);

			$rules = array();

				var_dump($csv);

			foreach ($csv->data as $ruleItem) {
				$rule = new SegmentationRule;
				//$rule->setListId($ruleItem['Segmentation ID']);
				$rule->setName($ruleItem['Segmentation Name']);
				$rule->setDescription($ruleItem['Description']);
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
		 */
		public function createSegmentationRule(SegmentationRule $segmentation_rule)
		{
			$form_data = array(
				'segmentation_name' => $segmentation_rule->getName(),
				'segmentation_type' => $segmentation_rule->getType(),
				'list_id' => $segmentation_rule->getListId(),
				'rules' => $segmentation_rule->getRules(),
				'description' => $segmentation_rule->getDescription()
			);
			$xml = $this->call('createseg', $form_data);

			$segmentation_rule->setId(trim($xml[1]));

			return $segmentation_rule;
		}

		/**
		 * @param SegmentationRule $segmentation_rule
		 *
		 * @return SegmentationRule
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669745
		 */
		public function updateSegmentationRule(SegmentationRule &$segmentation_rule)
		{
			$form_data = array(
				'segmentation_id' => $segmentation_rule->getId(),
				'segmentation_name' => $segmentation_rule->getName(),
				'segmentation_type' => $segmentation_rule->getType(),
				'list_id' => $segmentation_rule->getListId(),
				'rules' => $segmentation_rule->getRules(),
				'description' => $segmentation_rule->getDescription()
			);
			$xml = $this->call('updateseg', $form_data);

			return trim($xml[1]);
		}

		/**
		 * @param SegmentationRule $segmentation_rule
		 *
		 * @return SegmentationRule
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969459
		 */
		public function deleteSegmentationRule(SegmentationRule $segmentation_rule)
		{
			$form_data = array(
				'segmentation_id' => $segmentation_rule->getId()
			);
			$xml = $this->call('deleteseg', $form_data);

			return trim($xml[1]);
		}

		/**
		 * @param SegmentationRule $segmentation_rule
		 *
		 * @return mixed
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969449
		 */
		public function testSegmentationRule(SegmentationRule $segmentation_rule)
		{
			$form_data = array(
				'segmentation_id' => $segmentation_rule->getId(),
				'list_id' => $segmentation_rule->getListId()
			);
			$xml = $this->call('testseg', $form_data);

			return trim($xml[1]);
		}

		/**
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969479
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
				$template
					->setTemplateId((int)$template_item['Template Number'])
					->setName((string)$template_item['Template Name'])
					->setFolderId((int)$template_item['Folder ID']);
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
		 */
		public function getTemplateById($template_id)
		{
			$form_data = array(
				'template_id' => $template_id
			);
			$xml = $this->call('gettemplatebyid', $form_data);

			$template = new Template;
			$template
				->setFolderId((int)$xml->folder_id)
				->setTemplateId((int)$xml->template_id)
				->setName((string)$xml->template_name)
				->setSubject((string)$xml->template_subject)
				->setBodyPlain((string)$xml->body_plain)
				->setBodyHtml((string)$xml->body_html)
				->setDescription((string)$xml->template_description);

			return $template;
		}

		/**
		 * @param $template_name
		 *
		 * @return Template
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969489
		 */
		public function getTemplateByName($template_name)
		{
			$form_data = array(
				'template_name' => $template_name
			);
			$xml = $this->call('gettemplatebyname', $form_data);

			$template = new Template;
			$template
				->setFolderId((int)$xml->folder_id)
				->setTemplateId((int)$xml->template_id)
				->setName((string)$xml->template_name)
				->setSubject((string)$xml->template_subject)
				->setBodyPlain((string)$xml->body_plain)
				->setBodyHtml((string)$xml->body_html)
				->setDescription((string)$xml->template_description);

			return $template;
		}

		/**
		 * @param Template $template
		 *
		 * @return Template
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969469
		 */
		public function createTemplate(Template &$template)
		{
			$form_data = array(
				'template_name' => $template->getName(),
				'template_subject' => $template->getSubject(),
				'template_body_plain' => $template->getBodyPlain(),
				'template_body_html' => $template->getBodyHtml(),
				'template_body_mobile' => $template->getBodyMobile(),
				'charset' => $template->getCharacterSet(),
				'encoding' => $template->getCharacterEncoding(),
				'folder_id' => $template->getFolderId()
			);
			$data = $this->call('createtemplate', $form_data);

			$template->setTemplateId(trim($data[1]));

			//return $template;
		}

		/**
		 * @param Template $template
		 *
		 * @return Template
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669765
		 */
		public function updateTemplate(Template $template)
		{
			$form_data = array(
				'template_name' => $template->getName(),
				'template_subject' => $template->getSubject(),
				'template_body_plain' => $template->getBodyPlain(),
				'template_body_html' => $template->getBodyHtml(),
				'template_body_mobile' => $template->getBodyMobile(),
				'charset' => $template->getCharacterSet(),
				'encoding' => $template->getCharacterEncoding(),
				'folder_id' => $template->getFolderId()
			);
			$data = $this->call('updatetemplate', $form_data);

			return trim($data[1]);
		}

		/**
		 * @param Template $template
		 * @param $template_type
		 *
		 * @return Template
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669775
		 */
		public function previewTemplate(Template $template, $template_type)
		{
			$form_data = array(
				'template_name' => $template->getName(),
				'template_type' => $template_type
			);
			$data = $this->call('templatepreview', $form_data);

			return $data;
		}

		/**
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969509
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
				$article
					->setId((int)$article_item['Article Number'])
					->setName((string)$article_item['Name'])
					->setDescription((string)$article_item['Article Description'])
					->setFolderId((int)$article_item['Folder ID']);
				$articles[] = $article;
			}

			return $articles;
		}

		/**
		 * @param Article $article
		 *
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669805
		 */
		public function getArticleById(Article &$article)
		{
			$form_data = array(
				'article_id' => $article->getId()
			);
			$xml = $this->call('getarticlewithid', $form_data);

			$article
				->setName((string)$xml->name)
				->setTitle((string)$xml->title)
				->setDescription((string)$xml->article_description)
				->setDeck((string)$xml->deck)
				->setCallout((string)$xml->callout)
				->setBody((string)$xml->article_body)
				->setAuthorName((string)$xml->author_name)
				->setAuthorBio((string)$xml->author_bio)
				->setAuthorEmail((string)$xml->author_email)
				->setFolderId((int)$xml->folder_id);

			//return $article;
		}

		/**
		 * @param Article $article
		 *
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669805
		 */
		public function getArticleByName(Article &$article)
		{
			$form_data = array(
				'article_name' => $article->getName()
			);
			$xml = $this->call('getarticlewithname', $form_data);

			$article
				->setId((int)$xml->article_id)
				->setTitle((string)$xml->title)
				->setDescription((string)$xml->article_description)
				->setDeck((string)$xml->deck)
				->setCallout((string)$xml->callout)
				->setBody((string)$xml->article_body)
				->setAuthorName((string)$xml->author_name)
				->setAuthorBio((string)$xml->author_bio)
				->setAuthorEmail((string)$xml->author_email)
				->setFolderId((int)$xml->folder_id);

			//return $article;
		}

		/**
		 * @param $article_name
		 * @param $destination_article_name
		 *
		 * @return string
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669815
		 */
		public function copyArticle($article_name, $destination_article_name)
		{
			$form_data = array(
				'article_name' => $article_name,
				'dst_article_name' => $destination_article_name
			);
			$data = $this->call('copyarticle', $form_data);

			return trim($data[1]);
		}

		/**
		 * @param Article $article
		 *
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969499
		 */
		public function createBlankArticle(Article &$article)
		{
			$form_data = array(
				'article_name' => $article->getName()
			);
			$data = $this->call('createblankarticle', $form_data);

			$article->setId((int)trim($data[1]));
		}

		/**
		 * @param Article $article
		 *
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969499
		 */
		public function createArticle(Article &$article)
		{
			$form_data = array(
				'article_name' => $article->getName(),
				'article_title' => $article->getTitle(),
				'article_description' => $article->getDescription(),
				'deck' => $article->getDeck(),
				'callout' => $article->getCallout(),
				'author_name' => $article->getAuthorName(),
				'author_bio' => $article->getAuthorBio(),
				'author_email' => $article->getAuthorEmail(),
				'folder_id' => $article->getFolderId(),
				'article_body' => $article->getBody()
			);
			$data = $this->call('createarticle', $form_data);

			$article->setId((int)trim($data[1]));
		}

		/**
		 * @param Article $article
		 *
		 * @return boolean
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969519
		 */
		public function updateArticle(Article $article)
		{
			$form_data = array(
				'article_id' => $article->getId(),
				'article_name' => $article->getName(),
				'article_title' => $article->getTitle(),
				'article_description' => $article->getDescription(),
				'deck' => $article->getDeck(),
				'callout' => $article->getCallout(),
				'author_name' => $article->getAuthorName(),
				'author_bio' => $article->getAuthorBio(),
				'author_email' => $article->getAuthorEmail(),
				'folder_id' => $article->getFolderId(),
				'article_body' => $article->getBody()
			);
			$data = $this->call('updatearticle', $form_data);

			return TRUE;
		}

		/**
		 * @param $article_name
		 *
		 * @return boolean
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969529
		 */
		public function deleteArticle($article_name)
		{
			$form_data = array(
				'article_name' => $article_name
			);
			$data = $this->call('deletearticle', $form_data);

			return TRUE;
		}

		/**
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670035
		 */
		public function showABDefinitions()
		{
			$xml = $this->call('show_abdefinitions');

			$ab_tests = array();

			foreach ($xml->Data as $ab_test_item) {
				$ab_test = new ABTest;

				$is_testing_subject = $ab_test_item->test_subject == '1' ? TRUE : FALSE;
				$is_testing_from_address = $ab_test_item->test_from_address == '1' ? TRUE : FALSE;
				$is_testing_content = $ab_test_item->test_content == '1' ? TRUE : FALSE;
				$ab_test
					->setId((int)$ab_test_item->id)
					->setName((string)$ab_test_item->name)
					->setDescription((string)$ab_test_item->description)
					->setListId((int)$ab_test_item->list_id)
					->setListName((string)$ab_test_item->list_name)
					->setSegmentationRuleId((int)$ab_test_item->segmentation_rule_id)
					->setSuppressionList((string)$ab_test_item->suppression_list)
					->setMaxTime((int)$ab_test_item->max_time)
					->setMeasuring((string)$ab_test_item->measuring)
					->setNumSamples((int)$ab_test_item->num_samples)
					->setSampleSize((int)$ab_test_item->sample_size)
					->setSampleType((string)$ab_test_item->sample_type)
					->setTestSubject((boolean)$is_testing_subject)
					->setTestFromAddress((boolean)$is_testing_from_address)
					->setTestContent((boolean)$is_testing_content)
					->setTestEndsWhen((string)$ab_test_item->test_ends_when)
					->setThreshold((int)$ab_test_item->threshold)
					->setPostTestAction((string)$ab_test_item->post_test_action);
				$ab_tests[] = $ab_test;
			}

			return $ab_tests;
		}

		/**
		 * @param $ab_definition
		 *
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969789
		 */
		public function getABDefinition(&$ab_definition)
		{
			$form_data = array(
				'ab_definition_id' => $ab_definition->getId()
			);
			$xml = $this->call('getabdefinitionbyid', $form_data);

			$xml = $xml->Data;

			$is_testing_subject = $xml->test_subject == '1' ? TRUE : FALSE;
			$is_testing_from_address = $xml->test_from_address == '1' ? TRUE : FALSE;
			$is_testing_content = $xml->test_content == '1' ? TRUE : FALSE;
			$ab_definition
				->setId((int)$xml->id)
				->setName((string)$xml->name)
				->setDescription((string)$xml->description)
				->setListId((int)$xml->list_id)
				->setListName((string)$xml->list_name)
				->setSegmentationRuleId((int)$xml->segmentation_rule_id)
				->setSuppressionList((string)$xml->suppression_list)
				->setMaxTime((int)$xml->max_time)
				->setMeasuring((string)$xml->measuring)
				->setNumSamples((int)$xml->num_samples)
				->setSampleSize((int)$xml->sample_size)
				->setSampleType((string)$xml->sample_type)
				->setTestSubject((boolean)$is_testing_subject)
				->setTestFromAddress((boolean)$is_testing_from_address)
				->setTestContent((boolean)$is_testing_content)
				->setTestEndsWhen((string)$xml->test_ends_when)
				->setThreshold((int)$xml->threshold)
				->setPostTestAction((string)$xml->post_test_action);
		}

		/**
		 * @param $ab_definition_id
		 *
		 * @return ABTestStatistics
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670045
		 */
		public function reportABTestStatistics($ab_definition_id)
		{
			$form_data = array(
				'headers' => 1,
				'ab_definition_id' => $ab_definition_id
			);
			$data = $this->call('rpt_abstats', $form_data, 'csv');
			$csv = new \parseCSV($data);

			$ab_test_statistics = array();

			foreach ($csv->data as $ab_test_statistics_item) {
				$ab_test_statistic = new ABTestStatistics;
				$ab_test_statistic
					->setSample($ab_test_statistics_item['sample'])
					->setEncryptedId($ab_test_statistics_item['encrypted_id'])
					->setAbDefinitionId($ab_test_statistics_item['ab_definition_id'])
					->setAbResultId($ab_test_statistics_item['ab_result_id'])
					->setAbResultSampleId($ab_test_statistics_item['ab_result_sample_id'])
					->setTemplateId($ab_test_statistics_item['template_id'])
					->setTemplateName($ab_test_statistics_item['template_name'])
					->setSubject($ab_test_statistics_item['subject'])
					->setFromAddress($ab_test_statistics_item['from_address'])
					->setCampaignId($ab_test_statistics_item['campaign_id'])
					->setIsWinner($ab_test_statistics_item['is_winner'])
					->setIsDeployed($ab_test_statistics_item['is_deployed'])
					->setUniqueOpenRate($ab_test_statistics_item['unique_open_rate'])
					->setUniqueClickRate($ab_test_statistics_item['unique_click_rate'])
					->setTotalSent($ab_test_statistics_item['total_sent'])
					->setTotalDelivered($ab_test_statistics_item['total_delivered'])
					->setUniqueHardBounce($ab_test_statistics_item['unique_hard_bounce'])
					->setUniqueSoftBounce($ab_test_statistics_item['unique_soft_bounce'])
					->setUniqueBlocked($ab_test_statistics_item['unique_blocked'])
					->setTotalComplaints($ab_test_statistics_item['total_complaints'])
					->setTotalResponders($ab_test_statistics_item['total_responders'])
					->setTotalUnsubscribes($ab_test_statistics_item['total_unsubscribes'])
					->setUniqueComplaints($ab_test_statistics_item['unique_complaints'])
					->setClickToOpenRate($ab_test_statistics_item['click_to_open_rate'])
					->setOpenRate($ab_test_statistics_item['open_rate'])
					->setResponderRate($ab_test_statistics_item['responder_rate'])
					->setUnsubscribeRate($ab_test_statistics_item['unsubscribe_rate'])
					->setClickRate($ab_test_statistics_item['click_rate'])
					->setComplaintRate($ab_test_statistics_item['complaint_rate'])
					->setHardBounceRate($ab_test_statistics_item['hard_bounce_rate'])
					->setSoftBounceRate($ab_test_statistics_item['soft_bounce_rate'])
					->setBlockedRate($ab_test_statistics_item['blocked_rate'])
					->setDeliveredRate($ab_test_statistics_item['delivered_rate'])
					->setFbPosts($ab_test_statistics_item['fb_posts'])
					->setFbDisplays($ab_test_statistics_item['fb_displays'])
					->setDgUniquePosts($ab_test_statistics_item['fb_unique_posts'])
					->setFbUniqueDisplays($ab_test_statistics_item['fb_unique_displays'])
					->setTwPosts($ab_test_statistics_item['tw_posts'])
					->setTwDisplays($ab_test_statistics_item['tw_displays'])
					->setTwUniquePosts($ab_test_statistics_item['tw_unique_posts'])
					->setTwUniqueDisplays($ab_test_statistics_item['tw_unique_displays'])
					->setLnPosts($ab_test_statistics_item['ln_posts'])
					->setLnDisplays($ab_test_statistics_item['ln_displays'])
					->setLnUniquePosts($ab_test_statistics_item['ln_unique_posts'])
					->setLnUniqueDisplays($ab_test_statistics_item['ln_unique_displays'])
					->setDgPosts($ab_test_statistics_item['dg_posts'])
					->setDgDisplays($ab_test_statistics_item['dg_displays'])
					->setDgUniquePosts($ab_test_statistics_item['dg_unique_posts'])
					->setDgDisplays($ab_test_statistics_item['dg_unique_displays'])
					->setMspPosts($ab_test_statistics_item['msp_posts'])
					->setMspDisplays($ab_test_statistics_item['msp_displays'])
					->setMspUniquePosts($ab_test_statistics_item['msp_unique_posts'])
					->setMspUniqueDisplays($ab_test_statistics_item['msp_unique_displays'])
					->setVideoPlayed($ab_test_statistics_item['video_played'])
					->setVideoCheck25($ab_test_statistics_item['video_check_25'])
					->setVideoCheck50($ab_test_statistics_item['video_check_50'])
					->setVideoCheck75($ab_test_statistics_item['video_check_75'])
					->setVideoCheckCompleted($ab_test_statistics_item['video_check_completed'])
					->setTotalHardBounce($ab_test_statistics_item['total_hard_bounce'])
					->setTotalSoftBounce($ab_test_statistics_item['total_soft_bounce'])
					->setTotalBlocked($ab_test_statistics_item['total_blocked'])
					->setSocialShares($ab_test_statistics_item['social_shares'])
					->setSocialViews($ab_test_statistics_item['social_views'])
					->setSocialClicks($ab_test_statistics_item['social_clicks']);
				$ab_test_statistics[] = $ab_test_statistic;
			}

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
		 * @return boolean
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669835
		 */
		public function createCustomField(Field $field)
		{
			$form_data = array(
				'fieldname' => $field->getName(),
				'fieldtype' => $field->getType(),
				'description' => $field->getDescription()
			);
			$this->call('customfieldcreate', $form_data);

			return TRUE;
		}

		/**
		 * @param Field $field
		 *
		 * @return boolean
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669845
		 */
		public function deleteCustomField(Field $field)
		{
			$form_data = array(
				'fieldname' => $field->getName()
			);
			$this->call('customfielddelete', $form_data);

			return TRUE;
		}

		/**
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969549
		 */
		public function getSocialProviders()
		{
			$xml = $this->call('getsocialproviders');

			$social_providers = array();

			foreach ($xml->Data as $social_provider_item) {
				$social_provider = new SocialProvider;
				$social_provider
					->setProviderId((int)$social_provider_item->social_provider_id)
					->setProviderName((string)$social_provider_item->provider)
					->setUsername((string)$social_provider_item->username);
				$social_providers[] = $social_provider;
			}

			return $social_providers;
		}

		/**
		 * @param SocialProvider $social_provider
		 *
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669885
		 */
		public function getSocialProviderById(SocialProvider &$social_provider)
		{
			$form_data = array(
				'social_provider_id' => $social_provider->getProviderId()
			);
			$xml = $this->call('getsocialproviderbyid', $form_data);
			$xml = $xml->Data;

			$social_provider
				->setProviderName((string)$xml->provider)
				->setUsername((string)$xml->username);
		}

		/**
		 * @param SocialProvider $social_provider
		 *
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969559
		 */
		public function getSocialProviderByUserName(SocialProvider &$social_provider)
		{
			$form_data = array(
				'username' => $social_provider->getUsername(),
				'provider' => $social_provider->getProviderName()
			);
			$xml = $this->call('getsocialproviderbyusername', $form_data);
			$xml = $xml->Data;

			$social_provider
				->setProviderId((int)$xml->social_provider_id);
		}

		/**
		 * @param SocialProvider $social_provider
		 *
		 * @return bool
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969569
		 */
		public function deleteSocialProviderById(SocialProvider $social_provider)
		{
			$form_data = array(
				'social_provider_id' => $social_provider->getProviderId()
			);
			$this->call('deletesocialproviderbyid', $form_data);

			return TRUE;
		}

		/**
		 * @param SocialProvider $social_provider
		 *
		 * @return bool
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969579
		 */
		public function deleteSocialProviderByUserName(SocialProvider $social_provider)
		{
			$form_data = array(
				'provider' => $social_provider->getProviderName(),
				'username' => $social_provider->getUsername()
			);
			$this->call('deletesocialproviderbyusername', $form_data);

			return TRUE;
		}

		/**
		 * @param Template $template
		 * @param SocialProvider $social_provider
		 * @param SocialPost $social_post
		 *
		 * @return bool
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969589
		 */
		public function setSocialPostForTemplate(Template $template, SocialProvider $social_provider, SocialPost $social_post)
		{
			$form_data = array(
				'template_id' => $template->getTemplateId(),
				'provider' => $social_provider->getProviderName(),
				'post' => $social_post->getPost()
			);
			$this->call('setsocialpostfortemplate', $form_data);

			return TRUE;
		}

		/**
		 * @param Template $template
		 *
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969599
		 */
		public function getSocialPostsByTemplateId(Template $template)
		{
			$form_data = array(
				'template_id' => $template->getTemplateId()
			);
			$xml = $this->call('getsocialpostsfortemplatebyid', $form_data);

			$social_posts = array();

			foreach ($xml->Data as $social_post_item) {
				$social_post = new SocialPost();
				$social_post
					->setTemplateSocialPostId((int)$social_post_item->template_social_post_id)
					->setTemplateId((int)$social_post_item->template_id)
					->setProvider((string)$social_post_item->provider)
					->setPost((string)$social_post_item->post);
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
		 */
		public function getSocialPostsByTemplateName(Template $template)
		{
			$form_data = array(
				'template_name' => $template->getName()
			);
			$xml = $this->call('getsocialpostsfortemplatebyname', $form_data);

			$social_posts = array();

			foreach ($xml->Data as $social_post_item) {
				$social_post = new SocialPost();
				$social_post
					->setTemplateSocialPostId((int)$social_post_item->template_social_post_id)
					->setTemplateId((int)$social_post_item->template_id)
					->setProvider((string)$social_post_item->provider)
					->setPost((string)$social_post_item->post);
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
		 * @param Campaign $campaign
		 *
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669985
		 */
		public function launchCampaign(Campaign &$campaign)
		{
			$form_data = array(
				'list_id' => $campaign->getListId(),
				'template_id' => $campaign->getTemplateId(),
				'subject' => $campaign->getSubject(),
				'seed_list_id' => $campaign->getSeedListId(),
				'segmentation_id' => $campaign->getSegmentationId(),
				'format' => $campaign->getFormat(),
				'campaign_alias' => $campaign->getAlias(),
				'target_rss' => $campaign->getRss(),
				'vmta' => $campaign->getVmta(),
				'ab_definition_id' => $campaign->getAbDefinitionId(),
				'deployed_by_email' => $campaign->getDeployedByEmail(),
				'return_task_id' => $campaign->getReturnTaskId(),
				'delivery' => $campaign->getSeedDelivery(),
				'notify_email' => $campaign->getSendNotification()
			);
			$data = $this->call('launch', $form_data);

			if ($campaign->getReturnTaskId())
			{
				$campaign->setTaskId(trim($data[2]));
			}

		}

		/**
		 * @param Campaign $campaign
		 *
		 * @return bool
		 * @throws Exception
		 *
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204669995
		 */
		public function scheduleCampaign(Campaign &$campaign)
		{
			$form_data = array(
				'list_id' => $campaign->getListId(),
				'template_id' => $campaign->getTemplateId(),
				'format' => $campaign->getFormat(),
				'segmentation_id' => $campaign->getSegmentationId(),
				'seed_list_id' => $campaign->getSeedListId(),
				'suppression_list' => $campaign->getSupressionList(),
				'set_data_macro_id' => $campaign->getDataMacroId(),
				'campaign_alias' => $campaign->getAlias(),
				'target_rss' => $campaign->getRss(),
				'limit' => $campaign->getLimit(),
				'fillin_name0' => $campaign->getFillinName0(),
				'fillin_value0' => $campaign->getFillinValue0(),
				'fillin_name1' => $campaign->getFillinName1(),
				'fillin_value1' => $campaign->getFillinValue1(),
				'fillin_name2' => $campaign->getFillinName2(),
				'fillin_value2' => $campaign->getFillinValue2(),
				'fillin_name3' => $campaign->getFillinName3(),
				'fillin_value3' => $campaign->getFillinValue3(),
				'fillin_name4' => $campaign->getFillinName4(),
				'fillin_value4' => $campaign->getFillinValue4(),
				'fillin_name5' => $campaign->getFillinName5(),
				'fillin_value5' => $campaign->getFillinValue5(),
				'fillin_name6' => $campaign->getFillinName6(),
				'fillin_value6' => $campaign->getFillinValu60(),
				'fillin_name7' => $campaign->getFillinName7(),
				'fillin_value7' => $campaign->getFillinValue7(),
				'fillin_name8' => $campaign->getFillinName8(),
				'fillin_value8' => $campaign->getFillinValue8(),
				'fillin_name9' => $campaign->getFillinName9(),
				'fillin_value9' => $campaign->getFillinValue9(),
				'delivery' => $campaign->getSeedDelivery(),
				'notify_email' => $campaign->getSendNotification(),
				'start_month' => $campaign->getStartMonth(),
				'start_day' => $campaign->getStartDay(),
				'start_year' => $campaign->getStartYear(),
				'hour' => $campaign->getStartHour(),
				'minute' => $campaign->getStartMinute(),
				'end_month' => $campaign->getEndMonth(),
				'end_day' => $campaign->getEndDay(),
				'end_year' => $campaign->getEndYear(),
				'no_end_date' => $campaign->getNoEndDate(),
				'workflow_send_time' => $campaign->getWorkflowSendTime(),
				'repeat_frequency' => $campaign->getRepeatFrequency()
			);
			$this->call('schedule_deployment', $form_data);

			return TRUE;
		}

		/**
		 * @param $from
		 * @param $data
		 *
		 * @return bool
		 * @throws Exception
		 *
		 * @todo Create test in examples/
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670005
		 */
		public function processSpringbotAbandonedCart($from, $data)
		{
			$form_data = array(
				'from' => $from,
				'data' => $data
			);
			$this->call('springbot_process_abandoned_cart', $form_data);

			return TRUE;
		}

		/**
		 * @param $count
		 *
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969759
		 */
		public function showCampaigns($count)
		{
			$form_data = array(
				'count' => $count,
				'headers' => 1
			);
			$data = $this->call('show_campaigns', $form_data, 'csv');
			$csv = new \parseCSV($data);

			$campaigns = array();

			foreach ($csv->data as $campaign_item) {
				$campaign = new Report();
				$campaign
					->setCampaignId((int)$campaign_item['Campaign ID'])
					->setListName((string)$campaign_item['List Name'])
					->setSubject((string)$campaign_item['Subject'])
					->setDate(\DateTime::createFromFormat('m/d/y h:i A', $campaign_item['Date']))
					->setRecipients((int)$campaign_item['Recipients']);

				$campaigns[] = $campaign;
			}
			return $campaigns;
		}

		/**
		 * @param $start_date
		 * @param $end_date
		 * @param $show_hidden
		 *
		 * @return array|\SimpleXMLElement|string
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969769
		 */
		public function reportCampaignList($start_date, $end_date, $show_hidden)
		{
			$form_data = array(
				'from_date' => $start_date,
				'to_date' => $end_date,
				'show_hidden' => $show_hidden
			);
			$xml = $this->call('rpt_campaign_list', $form_data);

			$campaigns = array();

			foreach ($xml->Data as $campaign_item) {
				$campaign = new Report();
				$campaign
					->setCampaignId((int)$campaign_item->campaign_id)
					->setListId((int)$campaign_item->list_id)
					->setListName((string)$campaign_item->list_name)
					->setSubject((string)$campaign_item->subject)
					->setDate(\DateTime::createFromFormat('Y/m/d H:i:s', $campaign_item->deploy_date)) //2016-02-01 11:16:33
					->setRecipients((int)$campaign_item->pieces_sent)
					->setTaskId((int)$campaign_item->task_id);

				$campaigns[] = $campaign;
			}
			return $campaigns;
		}

		/**
		 * @param Report $campaign_statistics
		 *
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969799
		 */
		public function showCampaignStatistics(Report &$campaign_statistics)
		{
			$form_data = array(
				'campaign_id' => $campaign_statistics->getCampaignId()
			);
			$xml = $this->call('show_campaign_stats', $form_data);

			$campaign_statistics
				->setTaskId((int)$xml->task_id)
				->setListName((string)$xml->list_name)
				->setListId((int)$xml->list_id)
				->setSubject((string)$xml->subject)
				->setDate(\DateTime::createFromFormat('m/d/y h:i A', $xml->date))
				->setRecipients($this->groupedNumberToInt($xml->recipients))
				->setAlias((string)$xml->alias)
				->setTemplateName((string)$xml->template_name)
				->setSegmentation((string)$xml->segmentation)
				->setActive((string)$xml->active)
				->setSetMacroId((int)$xml->set_macro_id)
				->setCharacterSet((string)$xml->character_set)
				->setUnicode((string)$xml->unicode)
				->setQuotedPrintable((string)$xml->quoted_printable)
				->setForcedFormat((string)$xml->forced_format)
				->setDeployedBy((string)$xml->deployed_by)
				->setAutoMultipart((boolean)$xml->auto_multipart)
				->setWrapPlain((boolean)$xml->wrap_plain)
				->setWrapHtml((boolean)$xml->wrap_html)
				->setTrackOpens((boolean)$xml->track_opens)
				->setTrackClicks((boolean)$xml->track_clicks)
				->setHardBounces((int)$xml->hard_bounces)
				->setSoftBounces((int)$xml->soft_bounces)
				->setUnsubscribes((int)$xml->unsubscribes)
				->setDisplayMessageCount((int)$xml->display_message_count)
				->setTotalOpened((int)$xml->total_opened)
				->setTotalClicks((int)$xml->total_clicks)
				->setTotalFtafs((int)$xml->total_ftafs)
				->setTotalOpenedUnique((int)$xml->total_opened_unique)
				->setComplaintBounces((int)$xml->complaint_bounces)
				->setBlockedBounces((int)$xml->blocked_bounces)
				->setSocialShares((int)$xml->social_shares)
				->setSocialViews((int)$xml->social_views)
				->setSocialClicks((int)$xml->social_clicks)
				->setSocialProviderCount((int)$xml->social_provider_count);

			foreach ($xml->provider as $social_provider)
			{
				switch ($social_provider)
				{
					case 'Digg':
						$campaign_statistics
							->setDiggClicks((int)$social_provider->clicks)
							->setDiggShares((int)$social_provider->shares)
							->setDiggViews((int)$social_provider->views);
						break;
					case 'Facebook':
						$campaign_statistics
							->setFacebookClicks((int)$social_provider->clicks)
							->setFacebookShares((int)$social_provider->shares)
							->setFacebookViews((int)$social_provider->views);
						break;
					case 'LinkedIn':
						$campaign_statistics
							->setLinkedinClicks((int)$social_provider->clicks)
							->setLinkedinShares((int)$social_provider->shares)
							->setLinkedinViews((int)$social_provider->views);
						break;
					case 'Myspace':
						$campaign_statistics
							->setMyspaceClicks((int)$social_provider->clicks)
							->setMyspaceShares((int)$social_provider->shares)
							->setMyspaceViews((int)$social_provider->views);
						break;
					case 'Twitter':
						$campaign_statistics
							->setTwitterClicks((int)$social_provider->clicks)
							->setTwitterShares((int)$social_provider->shares)
							->setTwitterViews((int)$social_provider->views);
						break;
					case 'Google+':
						$campaign_statistics
							->setGooglePlusClicks((int)$social_provider->clicks)
							->setGooglePlusShares((int)$social_provider->shares)
							->setGooglePlusViews((int)$social_provider->views);
						break;
					case 'StumbleUpon':
						$campaign_statistics
							->setStumbleuponClicks((int)$social_provider->clicks)
							->setStumbleuponShares((int)$social_provider->shares)
							->setStumbleuponViews((int)$social_provider->views);
						break;
					case 'Pinterest':
						$campaign_statistics
							->setPinterestClicks((int)$social_provider->clicks)
							->setPinterestShares((int)$social_provider->shares)
							->setPinterestViews((int)$social_provider->views);
						break;
					default:
						break;
				}
			}

		}

		/**
		 * @param $campaign_ids
		 *
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969809
		 */
		public function showMultipleCampaginStatistics($campaign_ids)
		{
			$form_data = array(
				'campaigns' => implode(',', $campaign_ids),
				'headers' => 1
			);
			$data = $this->call('show_campaign_stats_multi', $form_data, 'csv');
			$csv = new \parseCSV($data);

			$campaign_statistics = array();

			foreach ($csv->data as $campaign_statistic_item) {
				$campaign = new Report();
				$campaign
					->setCampaignId((int)$campaign_statistic_item['Campaign ID'])
					->setListName((string)$campaign_statistic_item['List Name'])
					->setListId((int)$campaign_statistic_item['List ID'])
					->setSubject((string)$campaign_statistic_item['Subject'])
					->setDate(\DateTime::createFromFormat('m/d/y h:i A', $campaign_statistic_item['Date']))
					->setRecipients($this->groupedNumberToInt($campaign_statistic_item['Recipients']))
					->setAlias((string)$campaign_statistic_item['Alias'])
					->setTemplateName((string)$campaign_statistic_item['Template Name'])
					->setSegmentation((string)$campaign_statistic_item['Segmentation'])
					->setActive((string)$campaign_statistic_item['Active'])
					->setSetMacroId((int)$campaign_statistic_item['Set Macro ID'])
					->setCharacterSet((string)$campaign_statistic_item['Character Set'])
					->setUnicode((string)$campaign_statistic_item['Unicode'])
					->setQuotedPrintable((string)$campaign_statistic_item['Quoted Printable'])
					->setForcedFormat((string)$campaign_statistic_item['Forced Format'])
					->setDeployedBy((string)$campaign_statistic_item['Deployed By'])
					->setAutoMultipart((boolean)$this->stringToBoolean($campaign_statistic_item['Auto Multipart']))
					->setWrapPlain((boolean)$this->stringToBoolean($campaign_statistic_item['Wrap Plain']))
					->setWrapHtml((boolean)$this->stringToBoolean($campaign_statistic_item['Wrap HTML']))
					->setTrackOpens((boolean)$this->stringToBoolean($campaign_statistic_item['Track Opens']))
					->setTrackClicks((boolean)$this->stringToBoolean($campaign_statistic_item['Track Clicks']))
					->setDeliverability((boolean)$this->stringToBoolean($campaign_statistic_item['Deliverability']))
					->setHardBounces((int)$campaign_statistic_item['Hard Bounces'])
					->setSoftBounces((int)$campaign_statistic_item['Soft Bounces'])
					->setUnsubscribes((int)$campaign_statistic_item['Unsubscribes'])
					->setDisplayMessageCount((int)$campaign_statistic_item['Display Message Count'])
					->setTotalOpened((int)$campaign_statistic_item['Total Opened'])
					->setTotalClicks((int)$campaign_statistic_item['Total Clicks'])
					->setTotalFtafs((int)$campaign_statistic_item['Total FTAFs'])
					->setTotalOpenedUnique((int)$campaign_statistic_item['Total Opened Unique'])
					->setComplaintBounces((int)$campaign_statistic_item['Complaint Bounces'])
					->setBlockedBounces((int)$campaign_statistic_item['Blocked Bounces'])
					->setSocialShares((int)$campaign_statistic_item['Social Shares'])
					->setSocialViews((int)$campaign_statistic_item['Social Views'])
					->setSocialClicks((int)$campaign_statistic_item['Social Clicks'])
					->setSocialProviderCount((int)$campaign_statistic_item['Social Provider Count'])
					->setDiggClicks((int)$campaign_statistic_item['Digg Clicks'])
					->setDiggShares((int)$campaign_statistic_item['Digg Shares'])
					->setDiggViews((int)$campaign_statistic_item['Digg Views'])
					->setFacebookClicks((int)$campaign_statistic_item['Facebook Clicks'])
					->setFacebookShares((int)$campaign_statistic_item['Facebook Shares'])
					->setFacebookViews((int)$campaign_statistic_item['Facebook Views'])
					->setLinkedinClicks((int)$campaign_statistic_item['LinkedIn Clicks'])
					->setLinkedinShares((int)$campaign_statistic_item['LinkedIn Shares'])
					->setLinkedinViews((int)$campaign_statistic_item['LinkedIn Views'])
					->setMyspaceClicks((int)$campaign_statistic_item['Myspace Clicks'])
					->setMyspaceShares((int)$campaign_statistic_item['Myspace Shares'])
					->setMyspaceViews((int)$campaign_statistic_item['Myspace Views'])
					->setTwitterClicks((int)$campaign_statistic_item['Twitter Clicks'])
					->setTwitterShares((int)$campaign_statistic_item['Twitter Shares'])
					->setTwitterViews((int)$campaign_statistic_item['Twitter Views'])
					->setGooglePlusClicks((int)$campaign_statistic_item['Google+ Clicks'])
					->setGooglePlusShares((int)$campaign_statistic_item['Google+ Shares'])
					->setGooglePlusViews((int)$campaign_statistic_item['Google+ Views'])
					->setStumbleuponClicks((int)$campaign_statistic_item['StumbleUpon Clicks'])
					->setStumbleuponShares((int)$campaign_statistic_item['StumbleUpon Shares'])
					->setStumbleuponViews((int)$campaign_statistic_item['StumbleUpon Views'])
					->setPinterestClicks((int)$campaign_statistic_item['Pinterest Clicks'])
					->setPinterestShares((int)$campaign_statistic_item['Pinterest Shares'])
					->setPinterestViews((int)$campaign_statistic_item['Pinterest Views']);
				$campaign_statistics[] = $campaign;
			}
			return $campaign_statistics;
		}

		/**
		 * @param $campaign_id
		 *
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://support.whatcounts.com/hc/en-us/articles/204670075
		 */
		public function reportCampaignClicks($campaign_id)
		{
			$form_data = array(
				'campaign_id' => $campaign_id
			);
			$xml = $this->call('rpt_click_overview', $form_data);

			$campaigns_clicks = array();

			foreach ($xml->Data as $campaign_clicks_item)
			{
				$campaign_clicks = new CampaignClicks();
				$campaign_clicks
					->setUrl((string)$campaign_clicks_item->url)
					->setTotalClicks((int)$campaign_clicks_item->total_clicks)
					->setUniqueClicks((int)$campaign_clicks_item->unique_clicks)
					->setTrackingUrlId((int)$campaign_clicks_item->tracking_url_id);
				$campaigns_clicks[] = $campaign_clicks;
			}

			return $campaigns_clicks;
		}

		/**
		 * @param $campaign_id
		 * @param $url
		 * @param $is_exact
		 * @param $is_unique
		 *
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670085
		 */
		public function reportSubscriberClicks($campaign_id, $url, $is_exact, $is_unique)
		{
			$form_data = array(
				'campaign_id' => $campaign_id,
				'url' => $url,
				'exact' => $this->booleanToBit($is_exact),
				'is_unique' => $this->booleanToBit($is_unique)
			);
			$xml = $this->call('rpt_clicked_on', $form_data);

			$subscribers_clicks = array();

			foreach ($xml->Data as $subscriber_click_item)
			{
				$subscriber_click = new SubscriberClicks();
				$subscriber_click
					->setEmail((string)$subscriber_click_item->email)
					->setFirstName((string)$subscriber_click_item->first_name)
					->setLastName((string)$subscriber_click_item->last_name)
					->setEventDate(\DateTime::createFromFormat('Y-m-d H:i:s', $subscriber_click_item->event_date));
				$subscribers_clicks[] = $subscriber_click;
			}

			return $subscribers_clicks;
		}

		/**
		 * @param $campaign_id
		 * @param $start_date
		 * @param $end_date
		 *
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670095
		 */
		public function reportDailyStatistics($campaign_id, $start_date, $end_date)
		{
			$form_data = array(
				'campaign_id' => $campaign_id,
				'from_date' => $start_date,
				'to_date' => $end_date
			);
			$xml = $this->call('rpt_daily_stats', $form_data);

			$reports = array();

			foreach ($xml->Data as $daily_report)
			{
				$report = new Report();
				$report
					->setCampaignId((int)$daily_report->Campaign_ID)
					->setEventDate(\DateTime::createFromFormat('m/d/Y', $daily_report->event_date))
					->setTotalSent((int)$daily_report->Total_sent)
					->setTotalOpened((int)$daily_report->Total_opened)
					->setTotalOpenedUnique((int)$daily_report->Unique_opened)
					->setTotalClicks((int)$daily_report->Total_clickthroughs)
					->setTotalClicksUnique((int)$daily_report->Unique_clickthroughs)
					->setSoftBounces((int)$daily_report->Total_soft_bounced)
					->setHardBounces((int)$daily_report->Total_hard_bounced)
					->setUnsubscribes((int)$daily_report->Total_unsubscribed)
					->setComplaintBounces((int)$daily_report->Total_complaints_bounced)
					->setBlockedBounces((int)$daily_report->Total_blocked_bounced);
				$reports[] = $report;
			}

			return $reports;
		}

		/**
		 * @param $campaign_id
		 * @param int $by_subscriber
		 * @param $os_name
		 * @param $browser
		 * @param $client_type
		 *
		 * @return array|\SimpleXMLElement|string
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969819
		 */
		public function reportBrowserInfo($campaign_id, $by_subscriber=0, $os_name, $browser, $client_type)
		{
			$form_data = array(
				'campaign_id' => $campaign_id,
				'by_subscriber' => $by_subscriber,
				'os_name' => $os_name,
				'browser' => $browser,
				'client_type' => $client_type
			);
			$xml = $this->call('rpt_browser_info', $form_data);

			return $xml;
		}

		/**
		 * @param $campaign_id
		 * @param $bounce_type
		 * @param $start_date
		 * @param $end_date
		 *
		 * @return array
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670105
		 */
		public function reportBounceStatistics($campaign_id, $bounce_type, $start_date, $end_date)
		{
			$form_data = array(
				'campaign_id' => $campaign_id,
				'bounce_type' => $bounce_type,
				'from_date' => $start_date,
				'to_date' => $end_date,
				'headers' => 1
			);
			$data = $this->call('rpt_bounce_stats', $form_data, 'csv');
			$data .= PHP_EOL;
			$csv = new \parseCSV($data);

			return $csv->data;
		}

		/**
		 * @param $event_type
		 * @param $start_datetime
		 * @param $end_datetime
		 * @param $offset
		 *
		 * @return mixed
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969829
		 */
		public function reportTrackedEvents($event_type, $start_datetime, $end_datetime, $offset=0)
		{
			$form_data = array(
				'event_type' => $event_type,
				'start_datetime' => $start_datetime,
				'end_datetime' => $end_datetime,
				'offset' => $offset
			);
			$xml = $this->call('rpt_tracked_events', $form_data);

			return json_decode(json_encode($xml), TRUE);
		}

		/**
		 * @param $campaign_id
		 * @param $event_type
		 * @param $start_datetime
		 * @param $end_datetime
		 * @param $offset
		 *
		 * @return mixed
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969839
		 */
		public function reportTrackedEventsByCampaign($campaign_id, $event_type, $start_datetime, $end_datetime, $offset=0)
		{
			$form_data = array(
				'campaign_id' => $campaign_id,
				'event_type' => $event_type,
				'start_datetime' => $start_datetime,
				'end_datetime' => $end_datetime,
				'offset' => $offset
			);
			$xml = $this->call('rpt_tracked_events_by_campaign', $form_data);

			return json_decode(json_encode($xml), TRUE);
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
					->setDate(date_create_from_format('m/d/y h:i A', $reportItem{'Date'}));
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
					->setDate(date_create_from_format('m/d/y h:i A', $reportItem->date));
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

			return json_decode(json_encode($xml), TRUE);
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
		 * @param $list_id
		 * @param int $days
		 *
		 * @return mixed
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670145
		 */
		public function showHardBounces($list_id, $days = 30)
		{
			$form_data = array(
				'list_id' => $list_id,
				'days' => $days
			);
			$xml = $this->call('show_hard', $form_data);

			return json_decode(json_encode($xml->email), TRUE);
		}

		/**
		 * @param $list_id
		 * @param int $days
		 *
		 * @return mixed
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670155
		 */
		public function showSoftBounces($list_id, $days = 30)
		{
			$form_data = array(
				'list_id' => $list_id,
				'days' => $days
			);
			$xml = $this->call('show_soft', $form_data);

			return json_decode(json_encode($xml->email), TRUE);
		}

		/**
		 * @param $list_id
		 * @param int $days
		 *
		 * @return mixed
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969869
		 */
		public function showBlockBounces($list_id, $days = 30)
		{
			$form_data = array(
				'list_id' => $list_id,
				'days' => $days
			);
			$xml = $this->call('show_block', $form_data);

			return json_decode(json_encode($xml->email), TRUE);
		}

		/**
		 * @param $list_id
		 * @param int $days
		 *
		 * @return mixed
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/204670165
		 */
		public function showComplaints($list_id, $days = 30)
		{
			$form_data = array(
				'list_id' => $list_id,
				'days' => $days
			);
			$xml = $this->call('show_complaint', $form_data);

			return json_decode(json_encode($xml->email), TRUE);
		}

		/**
		 * @param $list_id
		 * @param $start_datetime
		 * @param $end_datetime
		 *
		 * @return mixed
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969669
		 */
		public function reportSubscriberByUpdate($list_id, $start_datetime, $end_datetime)
		{
			$form_data = array(
				'list_id' => $list_id,
				'start_datetime' => $start_datetime,
				'end_datetime' => $end_datetime
			);
			$xml = $this->call('rpt_sub_by_update_datetime', $form_data);

			return json_decode(json_encode($xml), TRUE);
		}

		/**
		 * @param $list_id
		 * @param int $offset
		 *
		 * @return mixed
		 * @throws Exception
		 *
		 * API documentation: https://whatcounts.zendesk.com/hc/en-us/articles/203969429
		 */
		public function reportSubscribersInList($list_id, $offset=0)
		{
			$form_data = array(
				'list_id' => $list_id,
				'offset' => $offset
			);
			$xml = $this->call('rpt_subscribers_in_list', $form_data);

			return json_decode(json_encode($xml), TRUE);
		}

		private function groupedNumberToInt($number)
		{
			$format = numfmt_create( 'en_US', \NumberFormatter::GROUPING_USED );
			return (int)numfmt_parse($format, $number);
		}

		private function stringToBoolean($string)
		{
			switch (strtolower($string))
			{
				case 't':
				case 'true':
				case '1':
				case 'yes':
					return TRUE;
					break;

				case 'f':
				case 'false':
				case '0':
				case 'no':
					return FALSE;
					break;
				default:
					return NULL;
			}
		}

		private function booleanToBit($boolean_value)
		{
			if ($boolean_value) {
				return '1';
			} else {
				return '0';
			}
		}
	}

