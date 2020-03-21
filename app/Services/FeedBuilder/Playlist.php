<?php

namespace App\Services\FeedBuilder;

use App\Core\Router;
use App\Services\RssWriter\RssChannel;
use App\Services\RssWriter\RssHelper;
use App\Services\RssWriter\RssItem;
use App\Services\Youtube\YoutubeHelper;
use Google_Service_YouTube;

/**
 * https://developers.google.com/youtube/v3/docs/channels/list
 * https://developers.google.com/youtube/v3/docs/playlistItems
 */
class Playlist extends FeedAbstract
{
    const MAX_RESULTS = 50;
    const PLAYLIST_IMAGE = 'images/youtube.png';

    protected $youtube;

    public function __construct(Google_Service_YouTube $youtube)
    {
        $this->youtube = $youtube;
    }

    protected function getItems(string $id): array
    {
        $playlistItems = $this->youtube->playlistItems->listPlaylistItems('snippet', [
            'playlistId' => $id,
            'maxResults' => self::MAX_RESULTS
        ]);
        $items = [];

        foreach ($playlistItems as $video) {

            if($video->snippet->thumbnails){

                $videoId = $video->snippet->resourceId->videoId;
                $link = YoutubeHelper::getVideoUrl($videoId);
                $image = $video->snippet->thumbnails->standard->url ??
                    $video->snippet->thumbnails->default->url;

                $item = new RssItem();
                $item->setTitle($video->snippet->title)
                    ->setLink($link)
                    ->setGuid($link)
                    ->setDescription(RssHelper::getDescriptionWithImage(
                        $video->snippet->description,
                        $image
                    ))
                    ->setPubDate(new \DateTime($video->snippet->publishedAt))
                    ->setEnclosure(Router::url(sprintf('video/%s', $videoId)))
                    ->setImage($image);

                $items[] = $item;
            }
        }

        return $items;
    }

    protected function getChannel(string $id): ?RssChannel
    {
        $items = $this->youtube->playlists->listPlaylists('snippet', [
            'id' => $id
        ]);

        $list = $items[0];
        if(!$list->snippet){
            return null;
        }

        $channel = new RssChannel();
        return $channel->setTitle($list->snippet->title)
            ->setDescription($list->snippet->description)
            ->setLink(YoutubeHelper::getPlayListUrl($list->id))
            ->setImage(Router::url(self::PLAYLIST_IMAGE));
    }
}