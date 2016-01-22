<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 1/21/16
 * Time: 1:48 PM
 */

namespace ZayconWhatCounts;

class WhatCounts {

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
	public function __construct( $realm=NULL, $password=NULL, $url=NULL )
	{
		$this
			->setRealm( $realm )
			->setPassword( $password )
			->setUrl( ($url === NULL) ? self::DEFAULT_URL : $url );
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
	public function setUrl( $url )
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
	public function setRealm( $realm )
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
	public function setPassword( $password )
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
		if ($this->realm === NULL)
		{
			throw new Exception('You must set the realm before making a call');
		}
		elseif ($this->password === NULL)
		{
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
	public function call( $command, $data=NULL )
	{
		if ($this->checkStatus())
		{
			$request = array(
				'form_params' => [
					'r' => $this->realm,
					'p' => $this->password,
					'c' => $command,
					'output_format' => 'xml'
				]
			);

			if (!empty($data))
			{
				$request = array_merge($request['form_params'], $data);
			}

			$guzzle = new \GuzzleHttp\Client;
			$response = $guzzle->request(
				'POST',
				$this->url,
				$request
			);

			$body = (string)$response->getBody();

			if ($body == 'Invalid credentials')
			{
				throw new Exception('Invalid Credentials');
			}

			return new \SimpleXMLElement($body);
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
}