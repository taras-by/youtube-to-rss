<?php

namespace App\Service;

use App\Core\Router;
use App\Model\ListModel;
use App\RssWriter\Rss;
use App\RssWriter\RssChannel;
use App\RssWriter\RssHelper;
use App\RssWriter\RssItem;

class FeedBuilderService
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getFeed(ListModel $list): string
    {
        $rssChannel = (new RssChannel())
            ->setTitle($list->getTitle())
            ->setDescription($list->getDescription())
            ->setLink($list->getLink())
            ->setImage($list->getImage());

        $rss = (new Rss())
            ->setChannel($rssChannel);

        foreach ($list->getItems() as $ListItem) {
            $rssItem = (new RssItem())
                ->setTitle($ListItem->getTitle())
                ->setLink($ListItem->getLink())
                ->setGuid($ListItem->getLink())
                ->setDescription(RssHelper::getDescriptionWithImage(
                    $ListItem->getDescription(),
                    $ListItem->getImage()
                ))
                ->setPubDate($ListItem->getPubDate())
                ->setEnclosure($this->router->url('video', ['videoId' => $ListItem->getId()]))
                ->setImage($ListItem->getImage());
            $rss->addItem($rssItem);
        }
        return $rss->getAsString();
    }
}
