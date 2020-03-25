<?php

namespace App\Validator;

class YoutubeLinkValidator
{
    const LINK_PATTERN_PLAYLIST = '/youtube.com\/playlist.+list=(.+)/i';
    const LINK_PATTERN_VIDEO = '/youtube.com\/watch.+v=(.+)/i';
    const LINK_PATTERN_CHANNEL = '/youtube.com\/channel\/(.+)/i';

    /**
     * @var string|null
     */
    private $link;

    /**
     * @var string|null
     */
    private $message;

    public function __construct(?string $link)
    {
        $this->link = $link;
    }

    /**
     * @return string[]
     */
    private function getPatterns()
    {
        return [
            self::LINK_PATTERN_PLAYLIST,
            self::LINK_PATTERN_CHANNEL,
            self::LINK_PATTERN_VIDEO,
        ];
    }

    /**
     * @return bool
     */
    public function validate()
    {
        if ($this->link == null) {
            $this->message = 'Link required';
            return false;
        }

        foreach ($this->getPatterns() as $pattern) {
            if (preg_match($pattern, $this->link)) {
                return true;
            }
        }

        $this->message = 'Invalid link format';
        return false;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }
}
