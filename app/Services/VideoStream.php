<?php

namespace App\Services;

class VideoStream
{
    const API_URL = 'http://www.youtube.com/get_video_info?video_id=';

    /**
     * @Todo Add Exceptions
     */
    public function getStreams($id)
    {
        $streams = [];
        parse_str(file_get_contents(self::API_URL . $id), $info);
        $streamMap = explode(',', $info['url_encoded_fmt_stream_map']);
        foreach ($streamMap as $streamString) {
            parse_str($streamString, $stream);
            $streams[] = $stream;
        }
        return $streams;
    }

    /**
     * @Todo Add Exceptions
     */
    public function getLink($id)
    {
        return $this->getStreams($id)[0]['url'];
    }
}