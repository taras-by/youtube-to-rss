<?php

namespace App\Model;

class ListModel
{
    /**
     * @var string
     */
    private $id;

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
    private $image;

    /**
     * @var string
     */
    private $link;

    /**
     * @var ListItemModel[]
     */
    private $items;

    /**
     * ListModel constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->items = [];
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

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
    public function setTitle(string $title): ListModel
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
    public function setImage($image): ListModel
    {
        $this->image = $image;

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
     * @return ListModel
     */
    public function setLink(string $link): self
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return ListItemModel[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param ListItemModel $item
     * @return ListModel
     */
    public function addItem(ListItemModel $item): ListModel
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): ListModel
    {
        $this->description = $description;

        return $this;
    }
}
