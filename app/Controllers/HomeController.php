<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Services\Playlist;
use App\Services\VideoStream;

class HomeController
{
    private $response;
    private $request;

    public function __construct(Response $response, Request $request)
    {
        $this->response = $response;
        $this->request = $request;
    }

    public function playlist(Playlist $playList): Response
    {
        $feed = $playList->getFeed($this->request->get['id']);
        return $this->response->view($feed)
            ->setHeader('Content-Type: text/xml');
    }

    public function video(VideoStream $video): Response
    {
        $url = $video->getLink($this->request->get['id']);
        return $this->response->setHeader(header('Location: ' . $url));
    }
}