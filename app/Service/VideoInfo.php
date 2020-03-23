<?php

namespace App\Service;

class VideoInfo
{
    const API_URL = 'https://www.youtube.com/get_video_info?video_id=%s';

    const QUALITY_HD720 = 'hd720';
    const QUALITY_MEDIUM = 'medium';
    const QUALITY_SMALL = 'small';
    const QUALITY_HD1080 = 'hd1080';

    const FORMAT_DEFAULT = 'mp4';
    const STATUS_OK = 'ok';

    const PLAYBILITY_STATUS_OK = 'OK';

    private $id;
    private $info;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getLink(string $quality = self::QUALITY_MEDIUM): string
    {
        $format = $this->getFormatByQuality($quality);

        if (!isset($format->url)) {
            throw new \RuntimeException('Format does not contain link to video');
        }

        return $format->url;
    }

    private function getInfo(): array
    {
        if (is_null($this->info)) {

            $content = @file_get_contents(sprintf(self::API_URL, $this->id));

            if ($content === FALSE) {
                throw new \RuntimeException("Cannot access to read contents.");
            }

            parse_str($content, $this->info);
        }

        if ($this->info['status'] != self::STATUS_OK) {
            throw new \RuntimeException($this->info['reason']);
        }

        return $this->info;
    }

    private function getFormats(): array
    {
        $info = $this->getInfo();

        if (!isset($info["player_response"])) {
            throw new \RuntimeException('player_response not found');
        }

        $playerResponse = json_decode($info["player_response"]);

        if ($playerResponse->playabilityStatus->status != self::PLAYBILITY_STATUS_OK) {
            throw new \RuntimeException($playerResponse->playabilityStatus->reason ?? 'Unknown reason');
        }

        if (!isset($playerResponse->streamingData->formats)) {
            throw new \RuntimeException('Streaming data not contain video formats');
        }

        return $playerResponse->streamingData->formats;
    }

    private function getFormatByQuality(string $quality): \stdClass
    {
        $result = null;
        $formats = $this->getFormats();

        foreach ($formats as $format) {
            if ($format->quality == $quality and strripos($format->mimeType, self::FORMAT_DEFAULT)) {
                $result = $format;
                break;
            } elseif ($format->quality == self::QUALITY_MEDIUM) {
                $result = $format;
            }
        }

        $result = $result ? $result : $formats[0];

        return $result;
    }
}
