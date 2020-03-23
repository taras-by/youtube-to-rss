<?php

namespace App\Model;

class ListModel
{
    private $title;
    private $description;
    private $link;
    private $image;

    /**
     * @var ListItemsModel[]
     */
    private $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): ListModel
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): ListModel
    {
        $this->description = $description;

        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): ListModel
    {
        $this->link = $link;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage($image): ListModel
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return ListItemsModel[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param ListItemsModel $item
     * @return ListModel
     */
    public function addItem(ListItemsModel $item): ListModel
    {
        $this->items[] = $item;
        return $this;
    }
}
