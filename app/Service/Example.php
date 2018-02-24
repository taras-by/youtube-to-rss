<?php

namespace App\Service;

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
}