<?php

namespace App\Services;

class YoutubeHelper
{
    const URL_VIDEO = 'https://www.youtube.com/watch?v=';
    const URL_PLAY_LIST = 'https://www.youtube.com/playlist?list=';

    static public function getVideoUrl(string $id): string
    {
        return self::URL_VIDEO . $id;
    }

    static public function getPlayListUrl(string $id): string
    {
        return self::URL_PLAY_LIST . $id;
    }
}