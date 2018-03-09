<?php

namespace App;

class Route
{
    public static function rules()
    {
        return [
            '/channel.xml' => 'HomeController@channel',
            '/playlist.xml' => 'HomeController@playlist',
            '/video' => 'HomeController@video',
        ];
    }
}