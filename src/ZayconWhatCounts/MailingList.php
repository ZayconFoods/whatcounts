<?php
/**
 * Created by PhpStorm.
 * User: marksimonds
 * Date: 1/25/16
 * Time: 1:35 PM
 */

namespace ZayconWhatCounts;

class MailingList
{
    private $list_id;
    private $list_name;
    private $description;
    private $template;
    private $from_address;
    private $reply_to_address;
    private $bounce_address;
    private $track_clicks = FALSE;
    private $track_opens = FALSE;
    private $folder_id;

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
     * @return MailingList
     */
    public function setListId($list_id)
    {
        $this->list_id = (is_numeric($list_id)) ? abs(round($list_id)) : NULL;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getListName()
    {
        return $this->list_name;
    }

    /**
     * @param mixed $list_name
     *
     * @return MailingList
     */
    public function setListName($list_name)
    {
        $this->list_name = $list_name;

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
     * @return MailingList
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     * @return MailingList
     */
    public function setTemplate($template)
    {
        $this->template = $template;
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
     * @return MailingList
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
     * @return MailingList
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
     * @return MailingList
     */
    public function setBounceAddress($bounce_address)
    {
        $this->bounce_address = $bounce_address;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isTrackClicks()
    {
        return $this->track_clicks;
    }

    /**
     * @param boolean $track_clicks
     * @return MailingList
     */
    public function setTrackClicks($track_clicks)
    {
        $this->track_clicks = ($track_clicks == 1 || $track_clicks == 'Y' || $track_clicks === TRUE) ? TRUE : FALSE;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isTrackOpens()
    {
        return $this->track_opens;
    }

    /**
     * @param boolean $track_opens
     * @return MailingList
     */
    public function setTrackOpens($track_opens)
    {
        $this->track_opens = ($track_opens == 1 || $track_opens == 'Y' || $track_opens === TRUE) ? TRUE : FALSE;
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
     *
     * @return MailingList
     */
    public function setFolderId($folder_id)
    {
        $this->folder_id = $folder_id;

        return $this;
    }

}
