<?php

namespace App\RssWriter;

class RssHelper
{
    /**
     * @param string $description
     * @param string|null $image
     * @return string
     */
    static public function getDescriptionWithImage(string $description, string $image = null): string
    {
        return $image ?
            '<p><img src="' . $image . '" /></p>' .
            '<div>' . $description . '</div>' : 
            $description;
    }
}