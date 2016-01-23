<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 1/21/16
 * Time: 3:39 PM
 */

namespace ZayconWhatCounts;

class Realm {

	private $realm_id;
	private $use_customer_key = FALSE;
	private $enable_relational_database = FALSE;

	/**
	 * @return mixed
	 */
	public function getRealmId()
	{
		return $this->realm_id;
	}

	/**
	 * @param mixed $realm_id
	 *
	 * @return Realm
	 */
	public function setRealmId( $realm_id )
	{
		$this->realm_id = (is_numeric($realm_id)) ? abs(round($realm_id)) : NULL;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getUseCustomerKey()
	{
		return $this->use_customer_key;
	}

	/**
	 * @param mixed $use_customer_key
	 *
	 * @return Realm
	 */
	public function setUseCustomerKey( $use_customer_key )
	{
		$this->use_customer_key = ($use_customer_key == 1 || $use_customer_key == 'Y' || $use_customer_key === TRUE) ? TRUE : FALSE;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getEnableRelationalDatabase()
	{
		return $this->enable_relational_database;
	}

	/**
	 * @param mixed $enable_relational_database
	 *
	 * @return Realm
	 */
	public function setEnableRelationalDatabase( $enable_relational_database )
	{
		$this->enable_relational_database = ($enable_relational_database == 1 || $enable_relational_database == 'Y' || $enable_relational_database === TRUE) ? TRUE : FALSE;

		return $this;
	}
}