<?php
/**
 * Created by PhpStorm.
 * User: marksimonds
 * Date: 1/27/16
 * Time: 8:52 AM
 */

namespace ZayconWhatCounts;


class SocialProvider
{
    private $provider_id;
    private $provider_name;
    private $username;

    /**
     * @return mixed
     */
    public function getProviderId()
    {
        return $this->provider_id;
    }

    /**
     * @param mixed $provider_id
     *
     * @return SocialProvider
     */
    public function setProviderId($provider_id)
    {
        $this->provider_id = $provider_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProviderName()
    {
        return $this->provider_name;
    }

    /**
     * @param mixed $provider_name
     *
     * @return SocialProvider
     */
    public function setProviderName($provider_name)
    {
        $this->provider_name = $provider_name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     *
     * @return SocialProvider
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }


}