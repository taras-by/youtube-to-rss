<?php

return [

    'google' => [
        'application_name' => GOOGLE_APPLICATION_NAME,
        'developer_key' => GOOGLE_DEVELOPER_KEY,
    ],

    'views' => [
        'views_path' => ROOT . 'app/Views/',
        'layout' => 'layout',
    ],

    'routes' => [
        '/' => 'HomeController::index',
        '/channel.xml' => 'HomeController::channel',
        '/playlist.xml' => 'HomeController::playlist',
        '/video' => 'HomeController::video',
    ]
];
