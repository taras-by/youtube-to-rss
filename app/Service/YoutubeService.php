<?php

namespace App\Service;

use App\Core\Router;
use App\Helper\YoutubeHelper;
use App\Model\ListItemsModel;
use App\Model\ListModel;
use Google_Service_YouTube;

class YoutubeService
{
    const MAX_RESULTS = 50;

    /**
     * @var Google_Service_YouTube
     */
    protected $youtube;

    /**
     * @var Router
     */
    private $router;

    public function __construct(Google_Service_YouTube $youtube, Router $router)
    {
        $this->youtube = $youtube;
        $this->router = $router;
    }

    public function getChannel(string $channelId): ?ListModel
    {
        $items = $this->youtube->channels->listChannels('snippet', [
            'id' => $channelId
        ]);

        if (!isset($items[0])) {
            return null;
        }
        $channel = $items[0];

        $list = (new ListModel())
            ->setTitle($channel->snippet->title)
            ->setDescription($channel->snippet->description)
            ->setLink(YoutubeHelper::getPlayListUrl($channel->id))
            ->setImage(
                $channel->snippet->thumbnails->high->url ??
                $channel->snippet->thumbnails->medium->url ??
                $channel->snippet->thumbnails->default->url
            );

        $listSearch = $this->youtube->search->listSearch('snippet', [
            'channelId' => $channelId,
            'order' => 'date',
            'type' => 'video',
            'maxResults' => self::MAX_RESULTS
        ]);

        foreach ($listSearch as $video) {
            if ($video->snippet->thumbnails) {

                $videoId = $video->id->videoId;
                $link = YoutubeHelper::getVideoUrl($videoId);
                $image = $video->snippet->thumbnails->standard->url ??
                    $video->snippet->thumbnails->default->url;

                $item = (new ListItemsModel())
                    ->setId($videoId)
                    ->setTitle($video->snippet->title)
                    ->setLink($link)
                    ->setDescription($video->snippet->description)
                    ->setPubDate(new \DateTime($video->snippet->publishedAt))
                    ->setImage($image);

                $list->addItem($item);
            }
        }

        return $list;
    }

    public function getPlaylist(string $channelId): ?ListModel
    {
        $items = $this->youtube->playlists->listPlaylists('snippet', [
            'id' => $channelId
        ]);

        $list = $items[0];
        if(!$list->snippet){
            return null;
        }

        $list = (new ListModel())
            ->setTitle($list->snippet->title)
            ->setDescription($list->snippet->description)
            ->setLink(YoutubeHelper::getPlayListUrl($list->id))
            ->setImage(
                $list->snippet->thumbnails->high->url ??
                $list->snippet->thumbnails->medium->url ??
                $list->snippet->thumbnails->default->url
            );

        $playlistItems = $this->youtube->playlistItems->listPlaylistItems('snippet', [
            'playlistId' => $channelId,
            'maxResults' => self::MAX_RESULTS
        ]);

        foreach ($playlistItems as $video) {
            if ($video->snippet->thumbnails) {

                $videoId = $video->snippet->resourceId->videoId;
                $link = YoutubeHelper::getVideoUrl($videoId);
                $image = $video->snippet->thumbnails->standard->url ??
                    $video->snippet->thumbnails->default->url;

                $item = (new ListItemsModel())
                    ->setId($videoId)
                    ->setTitle($video->snippet->title)
                    ->setLink($link)
                    ->setDescription($video->snippet->description)
                    ->setPubDate(new \DateTime($video->snippet->publishedAt))
                    ->setImage($image);

                $list->addItem($item);
            }
        }

        return $list;
    }
}
