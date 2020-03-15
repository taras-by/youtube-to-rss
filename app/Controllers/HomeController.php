<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use App\Core\Response;
use App\Services\FeedBuilder\Channel;
use App\Services\FeedBuilder\Playlist;
use App\Services\Generator\LinkGenerator;
use App\Services\Validator\YoutubeLinkValidator;
use App\Services\Youtube\VideoInfo;

class HomeController extends AbstractController
{
    public function index(Request $request, LinkGenerator $generator)
    {
        $youtubeLink = $request->get('youtube_link');
        $submit = $request->isMethod(Request::METHOD_POST);
        $validator = new YoutubeLinkValidator($youtubeLink);
        $generatedUrl = null;
        $errorMessage = null;
        if ($submit && $validator->validate()) {
            if (!$generatedUrl = $generator->generate($youtubeLink)) {
                $errorMessage = 'Error generating link';
            }
        } else {
            $errorMessage = $validator->getMessage();
        }
        return $this->getResponse()->render('index', compact('youtubeLink', 'generatedUrl', 'errorMessage', 'submit'));
    }

    public function channel(Request $request, Channel $channel): Response
    {
        $channelId = $request->get('id');
        if (!$channelId) {
            return $this->getResponse()->notFound();
        }

        $feed = $channel->getFeed($channelId);
        if (!$feed) {
            return $this->getResponse()->notFound();
        }

        return $this->getResponse()->view($feed)
            ->setHeader('Content-Type: text/xml');
    }

    public function playlist(Request $request, Playlist $playList): Response
    {
        $playListId = $request->get('id');
        if (!$playListId) {
            return $this->getResponse()->notFound();
        }

        $feed = $playList->getFeed($playListId);
        if (!$feed) {
            return $this->getResponse()->notFound();
        }

        return $this->getResponse()->view($feed)
            ->setHeader('Content-Type: text/xml');
    }

    public function video(Request $request): Response
    {
        $id = $request->get('id');
        $videoInfo = new VideoInfo($id);

        try {
            $url = $videoInfo->getLink();
            return $this->getResponse()
                ->setHeader(header('Location: ' . $url));
        } catch (\RuntimeException $exception) {
            return $this->getResponse()
                ->view($exception->getMessage())
                ->setHeader(header('HTTP/1.1 406 Not Acceptable'));
        }
    }

    private function getResponse(): Response
    {
        return $this->getContainer()->get(Response::class);
    }
}
