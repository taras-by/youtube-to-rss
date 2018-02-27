<?php

namespace App\Services;

class RssHelper
{
    static public function getDescriptionWithImage(string $description, string $image): string
    {
        return
            '<p><img src="' . $image . '" /></p>' .
            '<div>' . $description . '</div>';
    }
}