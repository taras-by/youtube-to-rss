<?php

namespace App\Generator;

use App\Core\Router;
use App\Validator\YoutubeLinkValidator;
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
     * @return string[][]
     */
    private function getConfig()
    {
        return [
            [
                'pattern' => YoutubeLinkValidator::LINK_PATTERN_VIDEO,
                'callback' => function ($youtubeUrl) {
                    $id = $this->getQueryParam($youtubeUrl, 'v');
                    return $this->router->url('video', ['videoId' => $id]);
                },
            ],
            [
                'pattern' => YoutubeLinkValidator::LINK_PATTERN_PLAYLIST,
                'callback' => function ($youtubeUrl) {
                    $id = $this->getQueryParam($youtubeUrl, 'list');
                    return $this->router->url('playlist', ['playlistId' => $id]);
                },
            ],
            [
                'pattern' => YoutubeLinkValidator::LINK_PATTERN_CHANNEL,
                'callback' => function (string $youtubeUrl, array $matches) {
                    $id = $matches[1];
                    return $this->router->url('channel', ['channelId' => $id]);
                },
            ],
        ];
    }

    /**
     * @param string $youtubeUrl
     * @return string|null
     * @throws Exception
     */
    public function generate(string $youtubeUrl): ?string
    {
        foreach ($this->getConfig() as $config) {
            if (preg_match($config['pattern'], $youtubeUrl, $matches)) {
                return $config['callback']($youtubeUrl, $matches);
            }
        }
        return null;
    }

    /**
     * @param string $url
     * @param string $name
     * @return string|null
     */
    private function getQueryParam(string $url, string $name): ?string
    {
        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $params);
        return $params[$name] ?? null;
    }
}
