<?php

namespace App\Service;

use App\Config;
use \Google_Client as googleClient;

class Google
{
    private $client;

    public function __construct(googleClient $client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        $this->client->setApplicationName(Config::GOOGLE_APPLICATION_NAME);
        $this->client->setDeveloperKey(Config::GOOGLE_DEVELOPER_KEY);
        return $this->client;
    }
}