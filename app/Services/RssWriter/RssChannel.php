<?php

namespace App\Services\RssWriter;

class RssChannel
{
    private $title;
    private $description;
    private $link;
    private $image;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): RssChannel
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): RssChannel
    {
        $this->description = $description;

        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): RssChannel
    {
        $this->link = $link;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage($image): RssChannel
    {
        $this->image = $image;

        return $this;
    }
}