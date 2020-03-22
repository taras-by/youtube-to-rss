<?php

namespace App\Controllers;

use App\Core\NotFoundHttpException;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\FeedBuilder\Channel;
use App\Services\FeedBuilder\Playlist;
use App\Services\Generator\LinkGenerator;
use App\Services\Validator\YoutubeLinkValidator;
use App\Services\Youtube\VideoInfo;

class HomeController extends AbstractController
{
    /**
     * @param Request $request
     * @param LinkGenerator $generator
     * @return Response
     * @throws Exception
     */
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
        $content = $this->render('index', compact('youtubeLink', 'generatedUrl', 'errorMessage', 'submit'));
        return new Response($content);
    }

    /**
     * @param string $channelId
     * @param Channel $channel
     * @return Response
     * @throws NotFoundHttpException
     */
    public function channel(string $channelId, Channel $channel): Response
    {
        if (!$feed = $channel->getFeed($channelId)) {
            throw new NotFoundHttpException('Channel not found');
        }
        return new Response($feed, Response::HTTP_OK, ['Content-Type' => 'xml']);
    }

    /**
     * @param string $playlistId
     * @param Playlist $playList
     * @return Response
     * @throws NotFoundHttpException
     */
    public function playlist(string $playlistId, Playlist $playList): Response
    {
        if (!$feed = $playList->getFeed($playlistId)) {
            throw new NotFoundHttpException('Playlist not found');
        }
        return new Response($feed, Response::HTTP_OK, ['Content-Type' => 'xml']);
    }

    /**
     * @param string $videoId
     * @return Response
     */
    public function video(string $videoId): Response
    {
        $videoInfo = new VideoInfo($videoId);

        try {
            $url = $videoInfo->getLink();
            return new RedirectResponse($url);
        } catch (\RuntimeException $exception) {
            return new Response($exception->getMessage(), Response::HTTP_NOT_ACCEPTABLE);
        }
    }
}
