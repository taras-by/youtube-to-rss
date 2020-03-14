<?php

namespace App\Services\FeedBuilder;

use App\Services\RssWriter\Rss;
use App\Services\RssWriter\RssChannel;

abstract class FeedAbstract
{
    public function getFeed(string $id): ?string
    {
        $rss = new Rss();

        $channel = $this->getChannel($id);
        if(!$channel){
            return null;
        }

        $rss->setChannel($channel);

        $items = $this->getItems($id);
        $rss->setItems($items);

        return $rss->getAsString();
    }

    protected abstract function getChannel(string $id): ?RssChannel;

    protected abstract function getItems(string $id): array;
}