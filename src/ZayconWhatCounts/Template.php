<?php
/**
 * Created by PhpStorm.
 * User: marksimonds
 * Date: 1/27/16
 * Time: 8:52 AM
 */

namespace ZayconWhatCounts;


class Template
{
    private $template_id;
    private $name;
    private $subject;
    private $body_plain;
    private $body_html;
    private $body_mobile;
    private $character_set;
    private $character_encoding;
    private $folder_id;
    private $description;

    /**
     * @return mixed
     */
    public function getTemplateId()
    {
        return $this->template_id;
    }

    /**
     * @param mixed $template_id
     *
     * @return Template
     */
    public function setTemplateId($template_id)
    {
        $this->template_id = $template_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Template
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     * @return Template
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBodyPlain()
    {
        return $this->body_plain;
    }

    /**
     * @param mixed $body_plain
     * @return Template
     */
    public function setBodyPlain($body_plain)
    {
        $this->body_plain = $body_plain;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBodyHtml()
    {
        return $this->body_html;
    }

    /**
     * @param mixed $body_html
     * @return Template
     */
    public function setBodyHtml($body_html)
    {
        $this->body_html = $body_html;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBodyMobile()
    {
        return $this->body_mobile;
    }

    /**
     * @param mixed $body_mobile
     * @return Template
     */
    public function setBodyMobile($body_mobile)
    {
        $this->body_mobile = $body_mobile;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCharacterSet()
    {
        return $this->character_set;
    }

    /**
     * @param mixed $character_set
     * @return Template
     */
    public function setCharacterSet($character_set)
    {
        $this->character_set = $character_set;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCharacterEncoding()
    {
        return $this->character_encoding;
    }

    /**
     * @param mixed $character_encoding
     * @return Template
     */
    public function setCharacterEncoding($character_encoding)
    {
        $this->character_encoding = $character_encoding;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFolderId()
    {
        return $this->folder_id;
    }

    /**
     * @param mixed $folder_id
     * @return Template
     */
    public function setFolderId($folder_id)
    {
        $this->folder_id = $folder_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return Template
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }


}