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
}