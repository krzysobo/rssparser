<?php

namespace KrzysztofSobolewskiRekrutacjaHRtec\Command\Traits;

use Symfony\Component\Console\Input\InputArgument;

/**
 * Trait DevCommandConfigure
 * @package KrzysztofSobolewskiRekrutacjaHRtec\Command\Traits
 */
trait DevCommandConfigure
{
    protected function configure()
    {
        $this
            ->addArgument(
                'feed_url',
                InputArgument::REQUIRED,
                "The full URL of the RSS/Atom feed")
            ->addArgument(
                'output_path',
                InputArgument::REQUIRED,
                "The path of the output CSV file");
    }
}
