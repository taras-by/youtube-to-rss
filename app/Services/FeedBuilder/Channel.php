<?php

namespace App\Services\FeedBuilder;

use App\Core\Router;
use App\Services\Youtube\Google;
use App\Services\RssWriter\RssChannel;
use App\Services\RssWriter\RssHelper;
use App\Services\RssWriter\RssItem;
use App\Services\Youtube\YoutubeHelper;

/**
 * https://developers.google.com/youtube/v3/docs/channels/list
 * https://developers.google.com/youtube/v3/docs/search/list
 */
class Channel extends FeedAbstract
{
    const MAX_RESULTS = 50;

    protected $youtube;

    public function __construct(Google $google)
    {
        $this->youtube = new \Google_Service_YouTube($google->getClient());
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

        return $items;
    }

    protected function getChannel(string $id): RssChannel
    {
        $items = $this->youtube->channels->listChannels('snippet', [
            'id' => $id
        ]);
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