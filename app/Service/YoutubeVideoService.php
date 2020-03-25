<?php

namespace App\Service;

use App\Model\VideoFormatModel;
use App\Model\VideoModel;
use RuntimeException;

class YoutubeVideoService
{
    const STATUS_OK = 'ok';
    const PLAYBILITY_STATUS_OK = 'OK';
    const API_URL = 'https://www.youtube.com/get_video_info?video_id=%s';

    /**
     * @param string $id
     * @return VideoModel
     * @throws RuntimeException
     */
    public function getVideoInfo(string $id): VideoModel
    {
        if(!$info = $this->getInfo($id)){
            throw new RuntimeException('Empty response');
        }

        if ($info['status'] != self::STATUS_OK) {
            throw new RuntimeException($info['reason']);
        }

        if (!isset($info["player_response"])) {
            throw new RuntimeException('player_response not found');
        }

        $playerResponse = json_decode($info["player_response"]);

        if ($playerResponse->playabilityStatus->status != self::PLAYBILITY_STATUS_OK) {
            throw new RuntimeException($playerResponse->playabilityStatus->reason ?? 'Unknown reason');
        }

        if (!isset($playerResponse->streamingData->formats)) {
            throw new RuntimeException('Streaming data not contain video formats');
        }

        $video = new VideoModel();
        foreach ($playerResponse->streamingData->formats as $format) {
            $format = (new VideoFormatModel())
                ->setQuality($format->quality)
                ->setMimeType($format->mimeType)
                ->setUrl($format->url);
            $video->addFormat($format);
        }
        return $video;
    }

    /**
     * @param string $id
     * @return array
     * @throws RuntimeException
     */
    private function getInfo(string $id): array
    {
        $content = @file_get_contents(sprintf(self::API_URL, $id));

        if ($content === FALSE) {
            throw new RuntimeException("Cannot access to read contents.");
        }

        parse_str($content, $info);

        return $info;
    }
}
