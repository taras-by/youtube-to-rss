<?php

namespace App\Services\RssWriter;

class RssItem
{
    private $title;
    private $description;
    private $link;
    private $guid;
    private $pubDate;
    private $image;
    private $enclosure;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): RssItem
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): RssItem
    {
        $this->description = $description;

        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): RssItem
    {
        $this->link = $link;

        return $this;
    }

    public function getGuid(): string
    {
        return $this->guid;
    }

    public function setGuid(string $guid): RssItem
    {
        $this->guid = $guid;

        return $this;
    }

    public function getPubDate(): \DateTime
    {
        return $this->pubDate;
    }

    public function setPubDate(\DateTime $pubDate): RssItem
    {
        $this->pubDate = $pubDate;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage($image): RssItem
    {
        $this->image = $image;

        return $this;
    }

    public function getEnclosure(): string
    {
        return $this->enclosure;
    }

    public function setEnclosure($enclosure): RssItem
    {
        $this->enclosure = $enclosure;

        return $this;
    }
}