<?php

namespace KrzysztofSobolewskiRekrutacjaHRtec\Service\Csv;

use KrzysztofSobolewskiRekrutacjaHRtec\Entity\FeedItem;
use KrzysztofSobolewskiRekrutacjaHRtec\Service\Logging;

/**
 * Class Writer
 * For writing data to CSV.
 * @package KrzysztofSobolewskiRekrutacjaHRtec\Service\Csv
 */
class Writer
{
    /**
     * @var string path to the output file
     */
    private $path;

    /**
     * @var string
     */
    private $tempPath;

    /**
     * @var array
     */
    private $oldData = [];

    /**
     * @var resource to the output file
     */
    private $fileHandle;

    /**
     * this header also defines the order of fields in the file
     * @var string[]
     */
    private $header;

    /**
     * @var false|mixed
     */
    private $appendMode;

    /**
     * Writer constructor.
     * @param $path
     * @param $header
     * @param false $appendMode
     */
    public function __construct($path, $header, $appendMode = false)
    {
        $this->path = $path;
        $this->tempPath = $this->path . "_tmp";

        $this->header = $header;
        $this->appendMode = $appendMode;

        Logging::getLogger()->info("CSV Writer has been initialized. File path: $this->path");
    }

    /**
     * reads the old data (if any) from the target file (if exists)
     */
    private function readOldData()
    {
        if (!file_exists($this->path)) {
            return;
        }

        $fp = fopen($this->path, 'rb');
        if ($fp === FALSE) {
            return;
        }

        $rowNum = 0;
        while ($row = fgetcsv($fp, 0, Utils::DELIMITER, Utils::ENCLOSURE)) {
            if (($rowNum == 0) && $row[0] == $this->header[0]) {  // omit the first row if it's header
                continue;
            }
            $this->oldData [] = $row;
            $rowNum++;
        }
    }

    /**
     * opens the CSV file
     */
    private function open()
    {
        $this->fileHandle = fopen($this->tempPath, 'wb');
        if ($this->appendMode) {
            $this->readOldData();
        }
    }

    /**
     * appends the old data (if any) to the target file
     */
    private function addOldData()
    {
        if (!$this->oldData) {
            return;
        }
        $lines = 0;
        foreach ($this->oldData as $row) {
            fputcsv($this->fileHandle, $row, Utils::DELIMITER, Utils::ENCLOSURE);
            $lines++;
        }
        if ($lines > 0) {
            Logging::getLogger()->info(sprintf("%d lines of data existed in the target file ", $lines));
        }
    }

    /**
     * closes the CSV file and rename temp path to target path
     * appends the old data (if exists0 at the end of the file.
     */
    public function close()
    {
        if ($this->appendMode) {
            $this->addOldData();
        }
        fclose($this->fileHandle);
        rename($this->tempPath, $this->path);
        Logging::getLogger()->info("The target CSV file $this->path has been written and closed.");
    }

    /**
     * writes the header (column names) into the CSV file
     */
    private function writeHeader()
    {
        fputcsv(
            $this->fileHandle,
            $this->header,
            Utils::DELIMITER,
            Utils::ENCLOSURE);
    }

    /**
     * Converts a FeedItem into array and writes it into the CSV file
     * @param $item
     */
    public function write(FeedItem $item)
    {
        if (!$this->fileHandle) {
            $this->open();
            $this->writeHeader();
        }

        $row = [];
        foreach ($this->header as $field) {
            $row [] = $item->{$field};
        }
        fputcsv(
            $this->fileHandle,
            $row,
            Utils::DELIMITER,
            Utils::ENCLOSURE);
    }
}