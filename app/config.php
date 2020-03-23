<?php

return [

    'google' => [
        'application_name' => getenv('GOOGLE_APPLICATION_NAME'),
        'developer_key' => getenv('GOOGLE_DEVELOPER_KEY'),
    ],

    'views' => [
        'views_path' => ROOT . 'app/View/',
        'layout' => 'layout',
    ],

    'routes' => [
        'index' => [
            /** @see HomeController::index() */
            'route' => '/',
            'action' => 'HomeController::index',
        ],
        'channel' => [
            /** @see FeedController::channel() */
            'route' => '/channel/{channelId}.xml',
            'action' => 'FeedController::channel',
        ],
        'playlist' => [
            /** @see FeedController::playlist() */
            'route' => '/playlist/{playlistId}.xml',
            'action' => 'FeedController::playlist',
        ],
        'video' => [
            /** @see VideoController::video() */
            'route' => '/video/{videoId}',
            'action' => 'VideoController::video',
        ],
    ]
];
