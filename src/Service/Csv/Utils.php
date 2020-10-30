<?php

namespace KrzysztofSobolewskiRekrutacjaHRtec\Service\Csv;

/**
 * Class Utils
 * @package KrzysztofSobolewskiRekrutacjaHRtec\Service\Csv
 */
class Utils
{
    public const DELIMITER = ";";
    public const ENCLOSURE = '"';

    /**
     * @param $fileName
     * @param $header
     * @return array
     */
    public static function readCsvFromFile($fileName, $header): array
    {
        $dataOut = [];
        $fp = fopen($fileName, 'rb');
        $rowNum = 0;
        while ($row = fgetcsv($fp, 0, self::DELIMITER, self::ENCLOSURE)) {
            if (($rowNum == 0) && $row[0] == $header[0]) {  // omit the first row if it's header
                continue;
            }
            $dataOut [] = $row;
            $rowNum++;
        }
        fclose($fp);
        return $dataOut;
    }

    /**
     * @return string[]
     */
    public static function getHeader(): array
    {
        return ["title", "description", "link", "pubDate", "creator"];
    }
}