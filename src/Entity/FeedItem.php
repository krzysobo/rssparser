<?php

namespace KrzysztofSobolewskiRekrutacjaHRtec\Entity;

/**
 * Class FeedItem
 * @package KrzysztofSobolewskiRekrutacjaHRtec\Entity
 */
class FeedItem extends Item
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $link;
    /**
     * @var DateTime
     */
    protected $pubDate;

    /**
     * @var string
     */
    protected $creator;

    /**
     * FeedItem constructor.
     * @param $title
     * @param $description
     * @param $link
     * @param $pubDate
     * @param $creator
     */
    public function __construct($title, $description, $link, $pubDate, $creator)
    {
        $this->title = $title;
        $this->description = $description;
        $this->link = $link;
        $this->pubDate = $pubDate;
        $this->creator = $creator;
    }

}