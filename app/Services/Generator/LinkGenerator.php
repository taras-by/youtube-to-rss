<?php

namespace App\Services\Generator;

use App\Core\Router;
use Exception;

class LinkGenerator
{
    /**
     * @var Router
     */
    private $router;

    /**
     * LinkGenerator constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param string $youtubeUrl
     * @return string|null
     * @throws Exception
     */
    public function generate(string $youtubeUrl): ?string
    {
        if (stripos($youtubeUrl, 'youtube.com/watch') !== false) {
            return $this->getVideoLink($youtubeUrl);
        }

        if (stripos($youtubeUrl, 'youtube.com/playlist') !== false) {
            return $this->getPlaylistLink($youtubeUrl);
        }

        if (stripos($youtubeUrl, 'youtube.com/channel') !== false) {
            return $this->getChannelLink($youtubeUrl);
        }

        return null;
    }

    /**
     * @param string $url
     * @return string|null
     * @throws Exception
     */
    private function getVideoLink(string $url)
    {
        if (!$id = $this->getQueryParam($url, 'v')) {
            return null;
        }
        return $this->router->url('video', ['videoId' => $id]);
    }

    /**
     * @param string $url
     * @return string|null
     * @throws Exception
     */
    private function getPlaylistLink(string $url)
    {
        if (!$id = $this->getQueryParam($url, 'list')) {
            return null;
        }
        return $this->router->url('playlist', ['playlistId' => $id]);
    }

    /**
     * @param string $url
     * @return string|null
     * @throws Exception
     */
    private function getChannelLink(string $url)
    {
        if (!$id = explode('channel/', $url)[1] ?? null) {
            return null;
        }
        return $this->router->url('channel', ['channelId' => $id]);
    }

    private function getQueryParam(string $url, string $name): ?string
    {
        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $params);
        return $params[$name] ?? null;
    }
}
