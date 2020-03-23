<?php

namespace App\Model;

use App\Helper\YoutubeHelper;

class ListItemModel
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
     * @var \DateTime
     */
    private $pubDate;

    /**
     * @var string
     */
    private $image;

    /**
     * ListItemModel constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
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
    public function setTitle(string $title): ListItemModel
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
    public function setDescription(string $description): ListItemModel
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPubDate(): \DateTime
    {
        return $this->pubDate;
    }

    /**
     * @param \DateTime $pubDate
     * @return $this
     */
    public function setPubDate(\DateTime $pubDate): ListItemModel
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
    public function setImage($image): ListItemModel
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return YoutubeHelper::getVideoUrl($this->getId());
    }
}
