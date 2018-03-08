<?php

namespace App\Services\Youtube;

class YoutubeHelper
{
    const URL_VIDEO = 'https://www.youtube.com/watch?v=%s';
    const URL_PLAY_LIST = 'https://www.youtube.com/playlist?list=%s';

    static public function getVideoUrl(string $id): string
    {
        return sprintf(self::URL_VIDEO, $id);
    }

    static public function getPlayListUrl(string $id): string
    {
        return sprintf(self::URL_PLAY_LIST, $id);
    }
}