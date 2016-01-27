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
 * @todo Group: A/B Testing, Add Show A/B Definitions function
 * @todo Group: A/B Testing, Add Get A/B Definition
 * @todo Group: A/B Testing, Add Report A/B Test Statistics
 * @todo Group: A/B Testing, Add Choose A/B Winner

 * @todo Group: Custom Fields, Add Create Custom Field
 * @todo Group: Custom Fields, Add Delete Custom Field

 * @todo Group: Social Media, Add Get Social Providers
 * @todo Group: Social Media, Add Get Social Provider by ID
 * @todo Group: Social Media, Add Get Social Provider by User Name
 * @todo Group: Social Media, Add Delete Social Provider by ID
 * @todo Group: Social Media, Add Delete Social Provider by User Name
 * @todo Group: Social Media, Add Set Social Post for Template
 * @todo Group: Social Media, Add Get Social Posts by Template ID
 * @todo Group: Social Media, Add Get Social Posts by Template Name

 * @todo Group: Send Mail, Add Send One-Off Message
 * @todo Group: Send Mail, Add Subscribe and Send One-Off Message
 * @todo Group: Send Mail, Add Launch Campaign
 * @todo Group: Send Mail, Add Schedule Campaign
 * @todo Group: Send Mail, Add Process SpringBot Abandoned Cart
 * @todo Group: Send Mail, Add Show Campaigns
 * @todo Group: Send Mail, Add Report Campaign List
 * @todo Group: Send Mail, Add Add Subscriber to Lifecycle Campaign

 * @todo Group: Reports, Add Show Campaign Statistics
 * @todo Group: Reports, Add Show Multiple Campaign Statistics
 * @todo Group: Reports, Add Report Campaign Clicks
 * @todo Group: Reports, Add Report Subscriber Clicks
 * @todo Group: Reports, Add Report Daily Statistics
 * @todo Group: Reports, Add Report Browser Info
 * @todo Group: Reports, Add Report Bounce Statistics
 * @todo Group: Reports, Add Report Tracked Events
 * @todo Group: Reports, Add Report Tracked Events by Campaign
 * @todo Group: Reports, Add Show User Events
 * @todo Group: Reports, Add Report Subscriber Events
 * @todo Group: Reports, Add Report Unsubscribes
 * @todo Group: Reports, Add Show Optouts
 * @todo Group: Reports, Add Show Global Optouts
 * @todo Group: Reports, Add Show Hard Bounces
 * @todo Group: Reports, Add Show Soft Bounces
 * @todo Group: Reports, Add Show Block Bounces
 * @todo Group: Reports, Add Show Complaints
 */

class WhatCounts
{

	const VERSION = '1.0.0';
	const DEFAULT_URL = 'https://api.whatcounts.com/bin/api_web';

	private $url;
	private $realm;
	private $password;

	/**
	 * WhatCounts constructor.
	 *
	 * @param null $realm
	 * @param null $password
	 * @param null $url
	 */
	public function __construct($realm = NULL, $password = NULL, $url = NULL)
	{
		$this
			->setRealm($realm)
			->setPassword($password)
			->setUrl(($url === NULL) ? self::DEFAULT_URL : $url);
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
					'r' => $this->realm,
					'p' => $this->password,
					'c' => $command,
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

			if ($body == 'Invalid credentials') {
				throw new Exception('Invalid Credentials');
			}

			if ((int)substr_compare($body, "FAILURE", 0, 7) == 0)
			{
				$result = explode(":", $body);
				throw new Exception($result[1]);
			}

			if ((int)substr_compare($body, "SUCCESS", 0, 7) == 0)
			{
				$result = explode(":", $body);
				return $result;
			}

			if ((int)substr_compare($body, "<Data>", 0, 6, 1) == 0) return new \SimpleXMLElement($body);
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

		foreach ($csv->data as $listItem)
		{
			$list = new MailingList;
			$list
				->setListId((int)$listItem{'List Number'}) // Whatcounts' show_lists command uses list_number instead of list_id
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
	 * @return MailingList
	 *
	 * @throws Exception
	 */
	public function exCreateList(MailingList $list)
	{
		$form_data = array(
			'list_name' => $list->getListName(),
			'description' => $list->getDescription(),
			'template_id' => $list->getTemplate(),
			'from' => $list->getFromAddress(),
			'reply_to' => $list->getReplyToAddress(),
			'errors_to' => $list->getBounceAddress(),
			'track_clicks' => $list->isTrackClicks(),
			'track_opens' => $list->isTrackOpens(),
			'folder_id' => $list->getFolderId()
		);
		$data = $this->call('excreatelist', $form_data);

		$list->setListId($data[1]);
		return $list;
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
			'list_name' => $list->getListName(),
			'description' => $list->getDescription(),
			'template_id' => $list->getTemplate(),
			'from' => $list->getFromAddress(),
			'reply_to' => $list->getReplyToAddress(),
			'errors_to' => $list->getBounceAddress(),
			'track_clicks' => $list->isTrackClicks(),
			'track_opens' => $list->isTrackOpens(),
			'folder_id' => $list->getFolderId()
		);
		$data = $this->call('createlist', $form_data);

		return TRUE;
	}

	/**
	 * @param MailingList $list
	 *
	 * @return MailingList
	 *
	 * @throws Exception
	 */
	public function updateList(MailingList $list)
	{
		$form_data = array(
			'list_id' => $list->getListId(),
			'list_name' => $list->getListName(),
			'description' => $list->getDescription(),
			'template_id' => $list->getTemplate(),
			'from' => $list->getFromAddress(),
			'reply_to' => $list->getReplyToAddress(),
			'errors_to' => $list->getBounceAddress(),
			'track_clicks' => $list->isTrackClicks(),
			'track_opens' => $list->isTrackOpens(),
			'folder_id' => $list->getFolderId()
		);
		$data = $this->call('updatelist', $form_data);
		$list->setListId($data[1]);

		return $list;
	}

	/**
	 * @param Subscriber $subscriber
	 * @param bool $exact_match
	 *
	 * @return array
	 * @throws Exception
	 */
	public function findSubscribers(Subscriber $subscriber, $exact_match = false)
	{
		$form_data = array(
			'email' => $subscriber->getEmail(),
			'first' => $subscriber->getFirstName(),
			'last' => $subscriber->getLastName(),
			'exact' => (int)$exact_match,
		);
		$xml = $this->call('find', $form_data);

		$subscribers = array();

		foreach ($xml->subscriber as $subscriberItem)
		{
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
	 * @param bool $exact_match
	 *
	 * @return array
	 * @throws Exception
	 */
	public function findSubscriberInList(Subscriber $subscriber, $exact_match = false)
	{
		$form_data = array(
			'email' => $subscriber->getEmail(),
			'first' => $subscriber->getFirstName(),
			'last' => $subscriber->getLastName(),
			'exact' => (int)$exact_match,
		);
		$xml = $this->call('findinlist', $form_data);

		$subscribers = array();

		foreach ($xml->subscriber as $subscriberItem)
		{
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
	 * @todo Populate $form_data with relevant fields from $subscriber
	 * @todo Create test in examples/
	 */
	public function subscribe(Subscriber $subscriber)
	{
		$form_data = array(
		);
		$xml = $this->call('sub', $form_data);

		return $subscriber;
	}

	/**
	 * @param Subscriber $subscriber
	 *
	 * @return Subscriber
	 * @throws Exception
	 *
	 * @todo Populate $form_data with relevant fields from $subscriber
	 * @todo Create test in examples/
	 */
	public function unsubscribe(Subscriber $subscriber)
	{
		$form_data = array(
		);
		$xml = $this->call('unsub', $form_data);

		return $subscriber;
	}

	/**
	 * @param Subscriber $subscriber
	 *
	 * @return Subscriber
	 * @throws Exception
	 *
	 * @todo Populate $form_data with relevant fields from $subscriber
	 * @todo Create test in examples/
	 */
	public function deleteSubscriber(Subscriber $subscriber)
	{
		$form_data = array(
		);
		$xml = $this->call('delete', $form_data);

		return $subscriber;
	}

	/**
	 * @param Subscriber $subscriber
	 *
	 * @return Subscriber
	 * @throws Exception
	 *
	 * @todo Populate $form_data with relevant fields from $subscriber
	 * @todo Create test in examples/
	 */
	public function showSubscriber(Subscriber $subscriber)
	{
		$form_data = array(
		);
		$xml = $this->call('detail', $form_data);

		return $subscriber;
	}

	/**
	 * @param Subscriber $subscriber
	 *
	 * @return Subscriber
	 * @throws Exception
	 *
	 * @todo Populate $form_data with relevant fields from $subscriber
	 * @todo Create test in examples/
	 */
	public function updateSubscriber(Subscriber $subscriber)
	{
		$form_data = array(
		);
		$xml = $this->call('update', $form_data);

		return $subscriber;
	}

	/**
	 * @param Subscriber $subscriber
	 *
	 * @return Subscriber
	 * @throws Exception
	 *
	 * @todo Populate $form_data with relevant fields from $subscriber
	 * @todo Create test in examples/
	 */
	public function changeEmailAddress(Subscriber $subscriber)
	{
		$form_data = array(
		);
		$xml = $this->call('change', $form_data);

		return $subscriber;
	}

	/**
	 * @param Subscriber $subscriber
	 *
	 * @return Subscriber
	 * @throws Exception
	 *
	 * @todo Populate $form_data with relevant fields from $subscriber
	 * @todo Create test in examples/
	 */
	public function addSubscriberToLifecycleCampaign(Subscriber $subscriber)
	{
		$form_data = array(
		);
		$xml = $this->call('addtolifecyclecampaign', $form_data);

		return $subscriber;
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

		foreach ($csv->data as $ruleItem)
		{
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
		$form_data = array(
		);
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
	public function updateSegmentationRule(SegmentationRule $segmentation_rule)
	{
		$form_data = array(
		);
		$xml = $this->call('updateseg', $form_data);

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
	public function deleteSegmentationRule(SegmentationRule $segmentation_rule)
	{
		$form_data = array(
		);
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
		$form_data = array(
		);
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

		foreach ($csv->data as $template_item)
		{
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
		$form_data = array(
		);
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
		$form_data = array(
		);
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
		$form_data = array(
		);
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

		foreach ($csv->data as $article_item)
		{
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
		$form_data = array(
		);
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
		$form_data = array(
		);
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
		$form_data = array(
		);
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
		$form_data = array(
		);
		$data = $this->call('deletearticle', $form_data);

		return $article;
	}
}

