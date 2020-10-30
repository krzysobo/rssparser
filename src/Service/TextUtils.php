<?php

namespace KrzysztofSobolewskiRekrutacjaHRtec\Service;

/**
 * Class TextUtils - various text-related static methods
 * @package KrzysztofSobolewskiRekrutacjaHRtec\Service
 */
class TextUtils
{
    /**
     * @param $text
     * @return string|string[]|null
     */
    public static function removeUrls($text): string
    {
        return preg_replace(
            '/\b((https?|ftp|file):\/\/|www\.)[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i',
            ' ',
            $text);
    }

}