<?php

namespace App\Service;

use App\Config;

class Google
{
    static public function getClient()
    {
        $client = new \Google_Client();
        $client->setApplicationName(Config::GOOGLE_APPLICATION_NAME);
        $client->setDeveloperKey(Config::GOOGLE_DEVELOPER_KEY);
        return $client;
    }
}