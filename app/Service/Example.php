<?php

namespace App\Service;

use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;

class Example
{
    const EXAMPLE_PLAYLIST = 'PLBCF2DAC6FFB574DE';

    protected $youtube;

    public function __construct(Google $google)
    {
        $this->youtube = new \Google_Service_YouTube($google->getClient());
    }

    public function getList()
    {
        $items = $this->youtube->playlistItems->listPlaylistItems('snippet,contentDetails', [
            'playlistId' => self::EXAMPLE_PLAYLIST
        ]);
        return $items;
    }

    public function getFeed(): string
    {
        $feed = new Feed();
        $channel = new Channel();
        $channel
            ->title('Channel Title')
            ->description('Channel Description')
            ->url('http://blog.example.com')
            ->appendTo($feed);

        return $feed;
    }
}