<?php

namespace App\Services\Youtube;

class VideoInfo
{
    const API_URL = 'http://www.youtube.com/get_video_info?video_id=%s';

    const QUALITY_HD720 = 'hd720';
    const QUALITY_MEDIUM = 'medium';
    const QUALITY_SMALL = 'small';
    const QUALITY_HD1080 = 'hd1080';

    const FORMAT_DEFAULT = 'mp4';
    const STATUS_DEFAULT = 'fail';

    private $id;
    private $info;
    private $decipher;

    public function __construct($id)
    {
        $this->id = $id;
        $this->decipher = new SignatureDecipher($id);
    }

    public function getInfo(): array
    {
        if (is_null($this->info)) {

            $content = @file_get_contents(sprintf(self::API_URL, $this->id));

            if ($content === FALSE) {
                throw new \RuntimeException("Cannot access to read contents.");
            }

            parse_str($content, $this->info);
        }

        if ($this->info['status'] == self::STATUS_DEFAULT) {
            throw new \RuntimeException($this->info['reason']);
        }

        return $this->info;
    }

    public function getStreams(): array
    {
        $streams = [];
        $info = $this->getInfo();
        $streamMap = explode(',', $info['url_encoded_fmt_stream_map']);
        foreach ($streamMap as $streamString) {
            parse_str($streamString, $stream);
            $streams[] = $stream;
        }
        return $streams;
    }

    public function getStreamByQuality(string $quality): array
    {
        $result = null;

        foreach ($this->getStreams() as $stream) {

            if ($stream['quality'] == $quality and strripos($stream['type'], self::FORMAT_DEFAULT)) {
                $result = $stream;
                break;
            } elseif ($stream['quality'] == self::QUALITY_MEDIUM) {
                $result = $stream;
            }
        }

        return $result;
    }

    public function getLink(string $quality = self::QUALITY_MEDIUM): string
    {
        $stream = $this->getStreamByQuality($quality);

        $url = $stream['url'];

        if (isset($stream['s'])) {
            $url .= '&signature=' . $this->decipher->getSignature($stream['s']);
        }
        return $url;
    }
}