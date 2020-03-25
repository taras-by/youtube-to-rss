<?php

namespace App\Helper;

class YoutubeHelper
{
    const URL_VIDEO = 'https://www.youtube.com/watch?v=%s';
    const URL_PLAY_LIST = 'https://www.youtube.com/playlist?list=%s';

    /**
     * @param string $id
     * @return string
     */
    static public function getVideoUrl(string $id): string
    {
        return sprintf(self::URL_VIDEO, $id);
    }

    /**
     * @param string $id
     * @return string
     */
    static public function getPlayListUrl(string $id): string
    {
        return sprintf(self::URL_PLAY_LIST, $id);
    }
}