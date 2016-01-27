<?php
/**
 * Created by PhpStorm.
 * User: marksimonds
 * Date: 1/27/16
 * Time: 10:41 AM
 */

namespace ZayconWhatCounts;


class SocialPost
{
    private $template_social_post_id;
    private $template_id;
    private $provider;
    private $post;

    /**
     * @return mixed
     */
    public function getTemplateSocialPostId()
    {
        return $this->template_social_post_id;
    }

    /**
     * @param mixed $template_social_post_id
     * @return SocialPost
     */
    public function setTemplateSocialPostId($template_social_post_id)
    {
        $this->template_social_post_id = $template_social_post_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTemplateId()
    {
        return $this->template_id;
    }

    /**
     * @param mixed $template_id
     * @return SocialPost
     */
    public function setTemplateId($template_id)
    {
        $this->template_id = $template_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param mixed $provider
     * @return SocialPost
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     * @return SocialPost
     */
    public function setPost($post)
    {
        $this->post = $post;
        return $this;
    }


}