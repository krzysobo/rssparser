<?php

namespace KrzysztofSobolewskiRekrutacjaHRtec\Command\Traits;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Exception\ParseException;
use FeedException;
use Exception;
use KrzysztofSobolewskiRekrutacjaHRtec\Service\Rss\Reader;
use KrzysztofSobolewskiRekrutacjaHRtec\Service\Rss\Converter;
use KrzysztofSobolewskiRekrutacjaHRtec\Service\Csv\Writer;
use KrzysztofSobolewskiRekrutacjaHRtec\Service\Csv\Utils;
use KrzysztofSobolewskiRekrutacjaHRtec\Exception\FieldDoesNotExistException;
use KrzysztofSobolewskiRekrutacjaHRtec\Service\Logging;

/**
 * Trait DevCommandParse
 * @package KrzysztofSobolewskiRekrutacjaHRtec\Command\Traits
 */
trait DevCommandParse
{
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param $appendMode
     */
    protected function parse(InputInterface $input, OutputInterface $output, $appendMode)
    {
        $feedUrl = $input->getArgument("feed_url");
        $outputPath = $input->getArgument("output_path");
        $reader = new Reader($feedUrl);
        $writer = new Writer(
            $outputPath,
            Utils::getHeader(),
            $appendMode);

        try {
            foreach ($reader->read() as $item) {
                $feedItem = Converter::convertToFeedItem($item);
                $writer->write($feedItem);
            }
            $writer->close();
        } catch (FeedException $e) {
            Logging::getLogger()->error(
                "The following problem(s) occured during feed parsing: " . $e->getMessage());
        } catch (FieldDoesNotExistException $e) {
            Logging::getLogger()->error(
                "FieldDoesNotExistException occured. Details: " . $e->getMessage());
        } catch (ParseException $e) {
            Logging::getLogger()->error(
                "Error occured during YAML parsing" . $e->getMessage());
        } catch (Exception $e) {
            Logging::getLogger()->error("Other exception occured: " . $e->getMessage());
        }
    }
}
