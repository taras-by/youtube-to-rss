<?php

return [

    'google' => [
        'application_name' => getenv('GOOGLE_APPLICATION_NAME'),
        'developer_key' => getenv('GOOGLE_DEVELOPER_KEY'),
    ],

    'views' => [
        'views_path' => ROOT . 'app/Views/',
        'layout' => 'layout',
    ],

    'routes' => [
        'index' => [
            'route' => '/',
            'action' => 'HomeController::index',
        ],
        'channel' => [
            'route' => '/channel/{channelId}.xml',
            'action' => 'HomeController::channel',
        ],
        'playlist' => [
            'route' => '/playlist/{playlistId}.xml',
            'action' => 'HomeController::playlist',
        ],
        'video' => [
            'route' => '/video/{videoId}',
            'action' => 'HomeController::video',
        ],
    ]
];
