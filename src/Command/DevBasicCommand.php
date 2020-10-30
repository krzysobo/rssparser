<?php

namespace KrzysztofSobolewskiRekrutacjaHRtec\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use KrzysztofSobolewskiRekrutacjaHRtec\Service\Logging;
use KrzysztofSobolewskiRekrutacjaHRtec\Command\Traits\DevCommandConfigure;
use KrzysztofSobolewskiRekrutacjaHRtec\Command\Traits\DevCommandParse;

/**
 * Class DevBasicCommand
 * @package KrzysztofSobolewskiRekrutacjaHRtec\Command
 */
class DevBasicCommand extends Command
{
    use DevCommandConfigure;
    use DevCommandParse;

    /**
     * @var string
     */
    protected static $defaultName = 'dev:basic';

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $log = Logging::getLogger();
        $log->info("{self::defaultName} has been started");
        $this->parse($input, $output, false);
        return Command::SUCCESS;
    }
}