<?php
/**
 * Created by PhpStorm.
 * User: taras
 * Date: 02.02.18
 * Time: 20:07
 */

namespace App;

class Route
{
    public static function rules()
    {
        return [
            '/playlist.xml' => 'HomeController@playlist',
            '/video' => 'HomeController@video',
        ];
    }
}