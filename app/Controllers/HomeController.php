<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Services\Playlist;
use App\Services\VideoInfo;

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

    public function video(): Response
    {
        $videoInfo = new VideoInfo($this->request->get['id']);

        try {
            $url = $videoInfo->getLink();
            return $this->response
                ->setHeader(header('Location: ' . $url));
        } catch (\RuntimeException $exception) {
            return $this->response
                ->view($exception->getMessage())
                ->setHeader(header('HTTP/1.1 406 Not Acceptable'));
        }
    }
}