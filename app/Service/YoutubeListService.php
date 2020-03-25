<?php

namespace App\Service;

use App\Core\Router;
use App\Model\ListItemModel;
use App\Model\ListModel;
use DateTime;
use Exception;
use Google_Service_YouTube;

class YoutubeListService
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

    /**
     * @param string $channelId
     * @return ListModel|null
     * @throws Exception
     */
    public function getChannel(string $channelId): ?ListModel
    {
        $items = $this->youtube->channels->listChannels('snippet', [
            'id' => $channelId
        ]);

        if (!isset($items[0])) {
            return null;
        }

        $list = $this->createListWithMetaData($items[0]);
        $list->setLink($this->router->url('channel', ['channelId' => $channelId]));

        $listSearch = $this->youtube->search->listSearch('snippet', [
            'channelId' => $channelId,
            'order' => 'date',
            'type' => 'video',
            'maxResults' => self::MAX_RESULTS
        ]);

        foreach ($listSearch as $itemData) {
            if (!$itemData->snippet->thumbnails) {
                continue;
            }
            $item = new ListItemModel($itemData->id->videoId);
            $this->fillListItem($item, $itemData);
            $list->addItem($item);
        }

        return $list;
    }

    /**
     * @param string $playlistId
     * @return ListModel|null
     * @throws Exception
     */
    public function getPlaylist(string $playlistId): ?ListModel
    {
        $items = $this->youtube->playlists->listPlaylists('snippet', [
            'id' => $playlistId
        ]);

        if (!isset($items[0])) {
            return null;
        }

        $list = $this->createListWithMetaData($items[0]);
        $list->setLink($this->router->url('playlist', ['playlistId' => $playlistId]));

        $playlistItems = $this->youtube->playlistItems->listPlaylistItems('snippet', [
            'playlistId' => $playlistId,
            'maxResults' => self::MAX_RESULTS
        ]);

        foreach ($playlistItems as $itemData) {
            if (!$itemData->snippet->thumbnails) {
                continue;
            }
            $item = new ListItemModel($itemData->snippet->resourceId->videoId);
            $this->fillListItem($item, $itemData);
            $list->addItem($item);
        }

        return $list;
    }

    /**
     * @param $listData
     * @return ListModel|null
     */
    private function createListWithMetaData($listData): ?ListModel
    {
        if (!$listData->snippet) {
            return null;
        }

        return (new ListModel($listData->id))
            ->setTitle($listData->snippet->title)
            ->setDescription($listData->snippet->description)
            ->setImage(
                $listData->snippet->thumbnails->high->url ??
                $listData->snippet->thumbnails->medium->url ??
                $listData->snippet->thumbnails->default->url
            );
    }

    /**
     * @param ListItemModel $listItem
     * @param $itemData
     * @return ListItemModel
     * @throws Exception
     */
    private function fillListItem(ListItemModel $listItem, $itemData)
    {
        $image = $video->snippet->thumbnails->standard->url ??
            $itemData->snippet->thumbnails->default->url;

        return $listItem
            ->setTitle($itemData->snippet->title)
            ->setDescription($itemData->snippet->description)
            ->setPubDate(new DateTime($itemData->snippet->publishedAt))
            ->setImage($image);
    }
}
