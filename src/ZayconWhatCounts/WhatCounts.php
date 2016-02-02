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

				return $body;
			}
		}

		/**
		 * @return Realm
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
			$data = $this->call('createlist', $form_data);

			return TRUE;
		}

		/**
		 * @param MailingList $list
		 *
		 * @return bool
		 *
		 * @throws Exception
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
			$data = $this->call('updatelist', $form_data);

			return TRUE;
		}

		/**
		 * @param Subscriber $subscriber
		 * @param bool $exact_match
		 *
		 * @return array
		 * @throws Exception
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
		 */
		public function subscribe(Subscriber $subscriber)
		{
			$form_data = array(
				'list_id'               => $subscriber->getListId(),
				'format'                => $subscriber->getFormat(),
				'force_sub'             => $subscriber->getForceSub(),
				'override_confirmation' => $subscriber->getOverrideConfirmation(),
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
		 */
		public function showSubscriber($subscriber_id)
		{
			$form_data = array(
				'subscriber_id' => $subscriber_id
			);
			$xml = $this->call('detail', $form_data);
			$subscriber_data = $xml->subscriber;

			$subscriber = new Subscriber;
			$subscriber->setSubscriberId((int)$subscriber_data->subscriber_id);
			$subscriber->setEmail((string)$subscriber_data->email);
			$subscriber->setFirstName((string)$subscriber_data->first);
			$subscriber->setLastName((string)$subscriber_data->last);
			$subscriber->setCompany((string)$subscriber_data->company);
			$subscriber->setAddress1((string)$subscriber_data->address_1);
			$subscriber->setAddress2((string)$subscriber_data->address_2);
			$subscriber->setCity((string)$subscriber_data->city);
			$subscriber->setState((string)$subscriber_data->state);
			$subscriber->setZip((string)$subscriber_data->zip);
			$subscriber->setCountry((string)$subscriber_data->country);
			$subscriber->setPhone((string)$subscriber_data->phone);
			$subscriber->setFax((string)$subscriber_data->fax);

			$list_ids = (array)explode(",", $subscriber_data->lists);
			$subscriber_lists = array();
			$subscription_details = $subscriber_data->subscription_details;

			foreach ($list_ids as $list_id) {
				$subscriber_list = New SubscriberList;
				$subscriber_list->setListId((int)$list_id);
				$subscriber_list->setCreatedDate($subscription_details->{'list_' . $list_id}->created_date);
				$subscriber_list->setLastSent($subscription_details->{'list_' . $list_id}->last_sent);
				$subscriber_list->setSentFlag($subscription_details->{'list_' . $list_id}->sent_flag);
				$subscriber_list->setFormat($subscription_details->{'list_' . $list_id}->format);

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
		 */
		public function changeEmailAddress(Subscriber &$subscriber, $new_email)
		{
			$form_data = array(
				'email'     => $subscriber->getEmail(),
				'email_new' => $new_email
			);
			$xml = $this->call('change', $form_data);

			$subscriber->setEmail($new_email);
		}

		/**
		 * @param Subscriber $subscriber
		 * @param $lc_campaign_name
		 *
		 * @return string
		 * @throws Exception
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
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function sendOneOffMessage()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function subscribeAndSendOneOffMessage()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function launchCampaign()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function scheduleCampaign()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function processSpringbotAbandonedCart()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function showCampaigns()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function reportCampaignList()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function showCampaignStatistics()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function showMultipleCampaginStatistics()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function reportCampaignClicks()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function reportSubscriberClicks()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function reportDailyStatistics()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function reportBrowserInfo()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function reportBounceStatistics()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function reportTrackedEvents()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function reportTrackedEventsByCampaign()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function showUserEvents()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function reportSubscriberEvents()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function reportUnsubscribes()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function showOptouts()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function showGlobalOptouts()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function showHardBounces()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function showSoftBounces()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function showBlockBounces()
		{

		}

		/**
		 * @todo Write function
		 * @todo Auto-document function
		 * @todo Create test in examples/
		 */
		public function showComplaints()
		{

		}
	}

