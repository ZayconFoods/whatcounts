<?php
/**
 * Created by PhpStorm.
 * User: marksimonds
 * Date: 1/26/16
 * Time: 3:29 PM
 */

namespace ZayconWhatCounts;


class Subscriber
{

    private $subscriber_id;
    private $list_id;
    private $list_count;
    private $customer_key;
    private $email;
    private $format;
    private $first_name;
    private $last_name;
    private $address_1;
    private $address_2;
    private $city;
    private $state;
    private $zip;
    private $country;
    private $phone;
    private $fax;
    private $company;
    private $override_confirmation;
    private $force_sub;
    private $lists = array();

    /**
     * @return mixed
     */
    public function getSubscriberId()
    {
        return $this->subscriber_id;
    }

    /**
     * @param mixed $subscriber_id
     * @return Subscriber
     */
    public function setSubscriberId($subscriber_id)
    {
        $this->subscriber_id = $subscriber_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getListId()
    {
        return $this->list_id;
    }

    /**
     * @param mixed $list_id
     * @return Subscriber
     */
    public function setListId($list_id)
    {
        $this->list_id = $list_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getListCount()
    {
        return $this->list_count;
    }

    /**
     * @param mixed $list_count
     * @return Subscriber
     */
    public function setListCount($list_count)
    {
        $this->list_count = $list_count;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomerKey()
    {
        return $this->customer_key;
    }

    /**
     * @param mixed $customer_key
     * @return Subscriber
     */
    public function setCustomerKey($customer_key)
    {
        $this->customer_key = $customer_key;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Subscriber
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param mixed $format
     * @return Subscriber
     */
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     * @return Subscriber
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     * @return Subscriber
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress1()
    {
        return $this->address_1;
    }

    /**
     * @param mixed $address_1
     * @return Subscriber
     */
    public function setAddress1($address_1)
    {
        $this->address_1 = $address_1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address_2;
    }

    /**
     * @param mixed $address_2
     * @return Subscriber
     */
    public function setAddress2($address_2)
    {
        $this->address_2 = $address_2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return Subscriber
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     * @return Subscriber
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param mixed $zip
     * @return Subscriber
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     * @return Subscriber
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return Subscriber
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param mixed $fax
     * @return Subscriber
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     * @return Subscriber
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOverrideConfirmation()
    {
        return $this->override_confirmation;
    }

    /**
     * @param mixed $override_confirmation
     * @return Subscriber
     */
    public function setOverrideConfirmation($override_confirmation)
    {
        $this->override_confirmation = $override_confirmation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getForceSub()
    {
        return $this->force_sub;
    }

    /**
     * @param mixed $force_sub
     * @return Subscriber
     */
    public function setForceSub($force_sub)
    {
        $this->force_sub = $force_sub;
        return $this;
    }

    /**
     * @return array
     */
    public function getLists()
    {
        return $this->lists;
    }

    /**
     * @param array $lists
     *
     * @return Subscriber
     */
    public function setLists($lists)
    {
        $this->lists = $lists;

        return $this;
    }

}

class SubscriberList
{
    private $list_id;
    private $created_date;
    private $last_sent;
    private $sent_flag;
    private $format;

    /**
     * @return mixed
     */
    public function getListId()
    {
        return $this->list_id;
    }

    /**
     * @param mixed $list_id
     *
     * @return SubscriberList
     */
    public function setListId($list_id)
    {
        $this->list_id = $list_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedDate()
    {
        return $this->created_date;
    }

    /**
     * @param mixed $created_date
     *
     * @return SubscriberList
     */
    public function setCreatedDate($created_date)
    {
        $this->created_date = $created_date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastSent()
    {
        return $this->last_sent;
    }

    /**
     * @param mixed $last_sent
     *
     * @return SubscriberList
     */
    public function setLastSent($last_sent)
    {
        $this->last_sent = $last_sent;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSentFlag()
    {
        return $this->sent_flag;
    }

    /**
     * @param mixed $sent_flag
     *
     * @return SubscriberList
     */
    public function setSentFlag($sent_flag)
    {
        $this->sent_flag = $sent_flag;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param mixed $format
     *
     * @return SubscriberList
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }


}