<?php

namespace App\Services\Validator;

use function DI\value;

class YoutubeLinkValidator
{

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

    public function validate()
    {
        if ($this->link == null) {
            $this->message = 'Link required';
            return false;
        }

        if (stripos($this->link, 'youtube') === false) {
            $this->message = 'Wrong link';
            return false;
        }

        return true;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }
}
