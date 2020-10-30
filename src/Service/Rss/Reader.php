<?php

namespace KrzysztofSobolewskiRekrutacjaHRtec\Service\Rss;

use Feed;
use KrzysztofSobolewskiRekrutacjaHRtec\Service\Logging;
use Generator;
use FeedException;

/**
 * Class Reader
 * For reading RSS/Atom feeds.
 * @package KrzysztofSobolewskiRekrutacjaHRtec\Service\Rss
 */
class Reader
{
    private $feedUrl;

    /**
     * Reader constructor.
     * @param $feedUrl
     */
    public function __construct($feedUrl)
    {
        $this->feedUrl = $feedUrl;

        Logging::getLogger()->info(
            "RSS Reader has been initialized. Reading RSS/Atom feed from URL: $feedUrl");
    }

    /**
     * @return Generator
     * @throws FeedException
     */
    public function read()
    {
        $channel = Feed::load($this->feedUrl);
        foreach ($channel->item as $item) {
            Logging::getLogger()->info(sprintf("Reading an item titled: %s", strval($item->title)));
            yield $item;
        }
    }
}