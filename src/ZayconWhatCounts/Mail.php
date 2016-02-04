<?php
/**
 * Created by PhpStorm.
 * User: marksimonds
 * Date: 1/27/16
 * Time: 8:49 AM
 */

namespace ZayconWhatCounts;


class Mail
{
    private $list_id;
    private $from_address;
    private $reply_to_address;
    private $bounce_address;
    private $sender_address;
    private $send_to_address;
    private $cc_to_address;
    private $template_id;
    private $body_text;
    private $body_html;
    private $subject;
    private $format;
    private $campaign_name;
    private $virtual_mta;
    private $first_name;
    private $duplicate = FALSE;
    private $ignore_optout = FALSE;
    private $character_encoding;
    private $data;

    /**
     * @return mixed
     */
    public function getListId()
    {
        return $this->list_id;
    }

    /**
     * @param mixed $list_id
     * @return Mail
     */
    public function setListId($list_id)
    {
        $this->list_id = $list_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFromAddress()
    {
        return $this->from_address;
    }

    /**
     * @param mixed $from_address
     * @return Mail
     */
    public function setFromAddress($from_address)
    {
        $this->from_address = $from_address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReplyToAddress()
    {
        return $this->reply_to_address;
    }

    /**
     * @param mixed $reply_to_address
     * @return Mail
     */
    public function setReplyToAddress($reply_to_address)
    {
        $this->reply_to_address = $reply_to_address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBounceAddress()
    {
        return $this->bounce_address;
    }

    /**
     * @param mixed $bounce_address
     * @return Mail
     */
    public function setBounceAddress($bounce_address)
    {
        $this->bounce_address = $bounce_address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSenderAddress()
    {
        return $this->sender_address;
    }

    /**
     * @param mixed $sender_address
     * @return Mail
     */
    public function setSenderAddress($sender_address)
    {
        $this->sender_address = $sender_address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSendToAddress()
    {
        return $this->send_to_address;
    }

    /**
     * @param mixed $send_to_address
     * @return Mail
     */
    public function setSendToAddress($send_to_address)
    {
        $this->send_to_address = $send_to_address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCcToAddress()
    {
        return $this->cc_to_address;
    }

    /**
     * @param mixed $cc_to_address
     * @return Mail
     */
    public function setCcToAddress($cc_to_address)
    {
        $this->cc_to_address = $cc_to_address;
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
     * @return Mail
     */
    public function setTemplateId($template_id)
    {
        $this->template_id = $template_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBodyText()
    {
        return $this->body_text;
    }

    /**
     * @param mixed $body_text
     * @return Mail
     */
    public function setBodyText($body_text)
    {
        $this->body_text = $body_text;
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
     * @return Mail
     */
    public function setBodyHtml($body_html)
    {
        $this->body_html = $body_html;
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
     * @return Mail
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
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
     * @return Mail
     */
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCampaignName()
    {
        return $this->campaign_name;
    }

    /**
     * @param mixed $campaign_name
     * @return Mail
     */
    public function setCampaignName($campaign_name)
    {
        $this->campaign_name = $campaign_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVirtualMta()
    {
        return $this->virtual_mta;
    }

    /**
     * @param mixed $virtual_mta
     * @return Mail
     */
    public function setVirtualMta($virtual_mta)
    {
        $this->virtual_mta = $virtual_mta;
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
     * @return Mail
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isDuplicate()
    {
        return $this->duplicate;
    }

    /**
     * @param mixed $duplicate
     * @return Mail
     */
    public function setDuplicate($duplicate)
    {
        $this->duplicate = ($duplicate == 1 || $duplicate == 'Y' || $duplicate === TRUE) ? TRUE : FALSE;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isIgnoreOptout()
    {
        return $this->ignore_optout;
    }

    /**
     * @param mixed $ignore_optout
     * @return Mail
     */
    public function setIgnoreOptout($ignore_optout)
    {
        $this->ignore_optout = ($ignore_optout == 1 || $ignore_optout == 'Y' || $ignore_optout === TRUE) ? TRUE : FALSE;
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
     * @return Mail
     */
    public function setCharacterEncoding($character_encoding)
    {
        $this->character_encoding = $character_encoding;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return Mail
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }


}