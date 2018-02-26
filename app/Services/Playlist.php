<?php

namespace App\Services;

use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

/**
 * https://developers.google.com/youtube/v3/docs/playlistItems
 */
class Playlist
{
    const MAX_RESULTS = 50;

    protected $youtube;
    protected $list;

    public function __construct(Google $google)
    {
        $this->youtube = new \Google_Service_YouTube($google->getClient());
    }

    public function getFeed(string $id): string
    {
        $feed = new Feed();
        $channel = $this->getChannel($this->getList($id));
        $channel->appendTo($feed);
        $this->appendItems($channel, $this->getItems($id));

        return $feed;
    }

    private function getItems(string $id)
    {
        $items = $this->youtube->playlistItems->listPlaylistItems('snippet,contentDetails', [
            'playlistId' => $id,
            'maxResults' => self::MAX_RESULTS
        ]);
        return $items;
    }
    private function getList(string $id)
    {
        $items = $this->youtube->playlists->listPlaylists('snippet,contentDetails', [
            'id' => $id
        ]);
        return $items[0];
    }

    private function getChannel($list): Channel
    {
        $channel = new Channel();

        return $channel
            ->title($list->snippet->title)
            ->description($list->snippet->description)
            ->url(YoutubeHelper::getPlayListUrl($list->id));
    }

    private function appendItems($channel, $list)
    {
        foreach ($list as $video) {

            $item = new Item();

            $item->url(YoutubeHelper::getVideoUrl($video->contentDetails->videoId));

            $item->title($video->snippet->title);
            $item->description($video->snippet->description);

            $item->appendTo($channel);
        }
    }
}