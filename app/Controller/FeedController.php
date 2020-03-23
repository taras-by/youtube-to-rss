<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\NotFoundHttpException;
use App\Service\FeedBuilderService;
use App\Service\YoutubeService;
use Symfony\Component\HttpFoundation\Response;

class FeedController extends AbstractController
{
    /**
     * @param string $channelId
     * @param YoutubeService $youtubeService
     * @param FeedBuilderService $feedBuilderService
     * @return Response
     * @throws NotFoundHttpException
     */
    public function channel(string $channelId, YoutubeService $youtubeService, FeedBuilderService $feedBuilderService): Response
    {
        if (!$channel = $youtubeService->getChannel($channelId)) {
            throw new NotFoundHttpException('Channel not found');
        }
        $feed = $feedBuilderService->getFeed($channel);
        return new Response($feed, Response::HTTP_OK, ['Content-Type' => 'xml']);
    }

    /**
     * @param string $playlistId
     * @param YoutubeService $youtubeService
     * @param FeedBuilderService $feedBuilderService
     * @return Response
     * @throws NotFoundHttpException
     */
    public function playlist(string $playlistId, YoutubeService $youtubeService, FeedBuilderService $feedBuilderService): Response
    {
        if (!$playlist = $youtubeService->getPlaylist($playlistId)) {
            throw new NotFoundHttpException('Playlist not found');
        }
        $feed = $feedBuilderService->getFeed($playlist);
        return new Response($feed, Response::HTTP_OK, ['Content-Type' => 'xml']);
    }
}
