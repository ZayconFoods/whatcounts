<?php
/**
 * Created by PhpStorm.
 * User: marksimonds
 * Date: 1/27/16
 * Time: 8:51 AM
 */

namespace ZayconWhatCounts;


class Article
{
    private $name;
    private $title;
    private $description;
    private $deck;
    private $callout;
    private $body;
    private $author_name;
    private $author_bio;
    private $author_email;
    private $folder_id;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Article
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * @return Article
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeck()
    {
        return $this->deck;
    }

    /**
     * @param mixed $deck
     * @return Article
     */
    public function setDeck($deck)
    {
        $this->deck = $deck;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCallout()
    {
        return $this->callout;
    }

    /**
     * @param mixed $callout
     * @return Article
     */
    public function setCallout($callout)
    {
        $this->callout = $callout;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return Article
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthorName()
    {
        return $this->author_name;
    }

    /**
     * @param mixed $author_name
     * @return Article
     */
    public function setAuthorName($author_name)
    {
        $this->author_name = $author_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthorBio()
    {
        return $this->author_bio;
    }

    /**
     * @param mixed $author_bio
     * @return Article
     */
    public function setAuthorBio($author_bio)
    {
        $this->author_bio = $author_bio;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthorEmail()
    {
        return $this->author_email;
    }

    /**
     * @param mixed $author_email
     * @return Article
     */
    public function setAuthorEmail($author_email)
    {
        $this->author_email = $author_email;
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
     * @return Article
     */
    public function setFolderId($folder_id)
    {
        $this->folder_id = $folder_id;
        return $this;
    }

}