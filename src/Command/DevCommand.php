<?php

namespace KrzysztofSobolewskiRekrutacjaHRtec\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class DevCommand
 * @package KrzysztofSobolewskiRekrutacjaHRtec\Command
 */
class DevCommand extends Command
{
    protected function configure()
    {
        parent::configure();
        $this
            ->addArgument(
                'input_url',
                InputArgument::REQUIRED,
                "The full URL of the RSS/Atom feed")
            ->addArgument(
                'output_path',
                InputArgument::REQUIRED,
                "The path of the output CSV file");

    }
}