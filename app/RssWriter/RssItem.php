<?php

namespace App\RssWriter;

use DateTime;

class RssItem
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $guid;

    /**
     * @var DateTime
     */
    private $pubDate;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $enclosure;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): RssItem
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): RssItem
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return $this
     */
    public function setLink(string $link): RssItem
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return string
     */
    public function getGuid(): string
    {
        return $this->guid;
    }

    /**
     * @param string $guid
     * @return $this
     */
    public function setGuid(string $guid): RssItem
    {
        $this->guid = $guid;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getPubDate(): DateTime
    {
        return $this->pubDate;
    }

    /**
     * @param DateTime $pubDate
     * @return $this
     */
    public function setPubDate(DateTime $pubDate): RssItem
    {
        $this->pubDate = $pubDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param $image
     * @return $this
     */
    public function setImage($image): RssItem
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function getEnclosure(): string
    {
        return $this->enclosure;
    }

    /**
     * @param $enclosure
     * @return $this
     */
    public function setEnclosure($enclosure): RssItem
    {
        $this->enclosure = $enclosure;

        return $this;
    }
}