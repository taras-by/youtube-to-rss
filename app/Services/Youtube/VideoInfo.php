<?php

namespace App\Services\Youtube;

class VideoInfo
{
    const API_URL = 'https://www.youtube.com/get_video_info?video_id=%s';

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

    public function getLink(string $quality = self::QUALITY_MEDIUM): string
    {
        $format = $this->getFormatByQuality($quality);
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

        if ($this->info['status'] == self::STATUS_DEFAULT) {
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

        return $playerResponse->streamingData->formats;
    }

    private function getFormatByQuality(string $quality): \stdClass
    {
        $result = null;

        foreach ($this->getFormats() as $format) {
            if ($format->quality == $quality and strripos($format->mimeType, self::FORMAT_DEFAULT)) {
                $result = $format;
                break;
            } elseif ($format->quality == self::QUALITY_MEDIUM) {
                $result = $format;
            }
        }

        return $result;
    }
}
