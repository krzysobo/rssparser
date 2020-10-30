<?php

namespace KrzysztofSobolewskiRekrutacjaHRtec\Service\Rss;

use DateTime;
use KrzysztofSobolewskiRekrutacjaHRtec\Entity\FeedItem;
use KrzysztofSobolewskiRekrutacjaHRtec\Service\Logging;
use KrzysztofSobolewskiRekrutacjaHRtec\Service\TextUtils;

/**
 * Class Converter
 * @package KrzysztofSobolewskiRekrutacjaHRtec\Service\Rss
 */
class Converter
{
    private const TARGET_DATE_FORMAT = 'd F Y H:i:s';

    /**
     * Converter constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $item
     * @return FeedItem
     */
    public static function convertToFeedItem($item): FeedItem
    {
        // original date format: Wed, 28 Oct 2020 15:38:09 GMT
        // requested date format: 28 October 2020 15:38:09 GMT
        $pubDate = DateTime::createFromFormat(
            DateTime::RSS,
            $item->pubDate);
        $title = strval($item->title);
        $description = strip_tags(strval($item->description));
        $description = TextUtils::removeUrls($description);
        $link = strval($item->link);
        $creator = strval($item->creator);

        return new FeedItem(
            $title,
            $description,
            $link,
            $pubDate->format(self::TARGET_DATE_FORMAT),
            $creator);
    }

}