<?php

namespace KrzysztofSobolewskiRekrutacjaHRtec;
require __DIR__ . '/../vendor/autoload.php';
define('ROOT_DIR', __DIR__);

use Symfony\Component\Console\Application;
use KrzysztofSobolewskiRekrutacjaHRtec\Command\DevBasicCommand;
use KrzysztofSobolewskiRekrutacjaHRtec\Command\DevExtendedCommand;

$app = new Application();

$app->add(new DevBasicCommand());
$app->add(new DevExtendedCommand());
$app->run();

//new Command();
