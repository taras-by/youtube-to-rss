<?php

namespace App\Services;

class RssHelper
{
    static public function getDescriptionWithImage(string $description, string $image = null): string
    {
        return $image ?
            '<p><img src="' . $image . '" /></p>' .
            '<div>' . $description . '</div>' : 
            $description;
    }
}