<?php

namespace App\Model;

class VideoFormatModel
{
    const QUALITY_MEDIUM = 'medium';
    const FORMAT_MP4 = 'mp4';

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $quality;

    /**
     * @var string
     */
    private $mimeType;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return VideoFormatModel
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuality(): string
    {
        return $this->quality;
    }

    /**
     * @param string $quality
     * @return VideoFormatModel
     */
    public function setQuality(string $quality): self
    {
        $this->quality = $quality;
        return $this;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     * @return VideoFormatModel
     */
    public function setMimeType(string $mimeType): self
    {
        $this->mimeType = $mimeType;
        return $this;
    }
}
