<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 1/21/16
 * Time: 1:48 PM
 */

namespace ZayconWhatCounts;

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
	 *
	 * @return \SimpleXMLElement
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
				throw new \Exception($result[1]);
			}

			if ((int)substr_compare($body, "SUCCESS", 0, 7) == 0)
			{
				$result = explode(":", $body);
				return $result;
			}

			if ((int)substr_compare($body, "<Data>", 0, 6) == 0) return new \SimpleXMLElement($body);
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
	 * @return MailingList
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
	 * @return MailingList
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
	 * @return MailingList
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
	 * @return MailingList
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
	 * @return bool
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
	 * @return MailingList
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

}

