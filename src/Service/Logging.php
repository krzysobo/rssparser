<?php

namespace KrzysztofSobolewskiRekrutacjaHRtec\Service;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Logging
{
    private static $logger;

    public static function getLogger($name = 'system'): Logger
    {
        if (!self::$logger) {
            $config = Config::getConfig();
            self::$logger = new Logger($name);
            self::$logger->pushHandler(
                new StreamHandler($config["log_path"], Logger::DEBUG));
            self::$logger->pushHandler(
                new StreamHandler("php://stdout", Logger::DEBUG));
        }

        return self::$logger;
    }
}