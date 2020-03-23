<?php

namespace App\Model;

class ListItemsModel
{
    private $id;
    private $title;
    private $description;
    private $link;
    private $pubDate;
    private $image;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId($id): ListItemsModel
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): ListItemsModel
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): ListItemsModel
    {
        $this->description = $description;

        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): ListItemsModel
    {
        $this->link = $link;

        return $this;
    }

    public function getPubDate(): \DateTime
    {
        return $this->pubDate;
    }

    public function setPubDate(\DateTime $pubDate): ListItemsModel
    {
        $this->pubDate = $pubDate;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage($image): ListItemsModel
    {
        $this->image = $image;

        return $this;
    }
}
