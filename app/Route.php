<?php

namespace App;

use App\Controllers\HomeController;

class Route
{
    public static function rules()
    {
        return [

            /**
             * @see HomeController::channel()
             */
            '/channel.xml' => 'HomeController@channel',

            /**
             * @see HomeController::playlist()
             */
            '/playlist.xml' => 'HomeController@playlist',

            /**
             * @see HomeController::video()
             */
            '/video' => 'HomeController@video',
        ];
    }
}