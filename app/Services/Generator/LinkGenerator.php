<?php

namespace App\Services\Generator;

use App\Core\Router;

class LinkGenerator
{
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

    private function getVideoLink(string $url)
    {
        if (!$id = $this->getQueryParam($url, 'v')) {
            return null;
        }
        return Router::url(sprintf('video/%s', $id));
    }

    private function getPlaylistLink(string $url)
    {
        if (!$id = $this->getQueryParam($url, 'list')) {
            return null;
        }
        return Router::url(sprintf('playlist/%s.xml', $id));
    }

    private function getChannelLink(string $url)
    {
        if (!$id = explode('channel/', $url)[1] ?? null) {
            return null;
        }
        return Router::url(sprintf('channel/%s.xml', $id));
    }

    private function getQueryParam(string $url, string $name): ?string
    {
        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $params);
        return $params[$name] ?? null;
    }
}
