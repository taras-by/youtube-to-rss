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
 * https://developers.google.com/youtube/v3/docs/search/list
 */
class Channel extends FeedAbstract
{
    const MAX_RESULTS = 50;

    protected $youtube;

    public function __construct(Google_Service_YouTube $youtube)
    {
        $this->youtube = $youtube;
    }

    protected function getItems(string $id): array
    {
        $listSearch = $this->youtube->search->listSearch('snippet', [
            'channelId' => $id,
            'order' => 'date',
            'type' => 'video',
            'maxResults' => self::MAX_RESULTS
        ]);
        $items = [];

        foreach ($listSearch as $video) {

            if($video->snippet->thumbnails){

                $videoId = $video->id->videoId;
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
                    ->setEnclosure(Router::url('video', ['id' => $videoId]))
                    ->setImage($image);

                $items[] = $item;
            }
        }

        return $items;
    }

    protected function getChannel(string $id): ?RssChannel
    {
        $items = $this->youtube->channels->listChannels('snippet', [
            'id' => $id
        ]);

        if(!isset($items[0])){
            return null;
        }
        $channel = $items[0];

        $rssChannel = new RssChannel();
        return $rssChannel->setTitle($channel->snippet->title)
            ->setDescription($channel->snippet->description)
            ->setLink(YoutubeHelper::getPlayListUrl($channel->id))
            ->setImage(
                $channel->snippet->thumbnails->high->url ??
                $channel->snippet->thumbnails->medium->url ??
                $channel->snippet->thumbnails->default->url
            );
    }
}