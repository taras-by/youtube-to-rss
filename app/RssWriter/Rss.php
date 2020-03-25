<?php

namespace App\RssWriter;

use SimpleXMLElement;

class Rss
{
    const NAMESPACE_ITUNES = 'http://www.itunes.com/dtds/podcast-1.0.dtd';
    const NAMESPACE_ATOM = 'http://www.w3.org/2005/Atom';
    const NAMESPACE_CONTENT = 'http://purl.org/rss/1.0/modules/content/';

    /**
     * @var SimpleXMLElement
     */
    private $rss;

    /**
     * @var RssChannel
     */
    private $channel;
    /**
     * @var RssItem[]
     */
    private $items = [];

    /**
     * Rss constructor.
     */
    public function __construct()
    {
        $this->rss = new SimpleXMLElement(
            '<rss ' .
            'xmlns:content="' . self::NAMESPACE_CONTENT . '" ' .
            'xmlns:atom="' . self::NAMESPACE_ATOM . '" ' .
            'xmlns:itunes="' . self::NAMESPACE_ITUNES . '" ' .
            '/>');
    }

    private function build()
    {
        $this->rss->addAttribute('version', '2.0');

        $channel = $this->rss->addChild('channel');
        $channel->addChild('title', $this->channel->getTitle());
        $channel->addChild('description', $this->channel->getDescription());
        $channel->addChild('link', $this->channel->getLink());

        $channel->addChild('itunes:image', null, self::NAMESPACE_ITUNES)
            ->addAttribute('href', $this->channel->getImage());

        /**
         * @var $rssItem RssItem
         */
        foreach ($this->items as $rssItem) {
            $item = $channel->addChild('item');
            $item->addChild('title', htmlspecialchars($rssItem->getTitle()));
            $item->addChild('description', htmlspecialchars($rssItem->getDescription()));
            $item->addChild('link', $rssItem->getLink());
            $item->addChild('guid', $rssItem->getGuid());
            $item->addChild('pubDate', $rssItem->getPubDate()->format(\DateTime::RSS));

            $enclosure = $item->addChild('enclosure');
            $enclosure->addAttribute('url',$rssItem->getEnclosure());
            $enclosure->addAttribute('type','video/mpeg');

            $item->addChild('itunes:image', null, self::NAMESPACE_ITUNES)
                ->addAttribute('href', $rssItem->getImage());
        }
    }

    /**
     * @return string
     */
    public function getAsString(): string
    {
        $this->build();
        return $this->rss->asXML();
    }

    /**
     * @param RssChannel $channel
     * @return $this
     */
    public function setChannel(RssChannel $channel): Rss
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @param RssItem[] $items
     * @return $this
     */
    public function setItems(array $items): Rss
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @param RssItem $item
     * @return $this
     */
    public function addItem(RssItem $item): Rss
    {
        $this->items[] = $item;

        return $this;
    }
}