<?php

namespace App\Model;

class VideoModel
{
    /**
     * @var VideoFormatModel[]
     */
    private $formats;

    public function __construct()
    {
        $this->formats = [];
    }

    /**
     * @return ListItemModel[]
     */
    private function getFormats(): array
    {
        return $this->formats;
    }

    /**
     * @param VideoFormatModel $format
     * @return VideoModel
     */
    public function addFormat(VideoFormatModel $format): self
    {
        $this->formats[] = $format;
        return $this;
    }

    /**
     * @param string $quality
     * @return VideoFormatModel
     */
    public function getFormatByQuality(string $quality): VideoFormatModel
    {
        $result = null;
        foreach ($this->getFormats() as $format) {
            if ($format->getQuality() == $quality and strripos($format->getMimeType(), VideoFormatModel::FORMAT_MP4)) {
                $result = $format;
                break;
            } elseif ($format->getQuality() == VideoFormatModel::QUALITY_MEDIUM) {
                $result = $format;
            }
        }

        $result = $result ? $result : $this->getFormats()[0];
        return $result;
    }

    public function getMediumQualityFormat(): VideoFormatModel
    {
        return $this->getFormatByQuality(VideoFormatModel::QUALITY_MEDIUM);
    }
}
