<?php

namespace KrzysztofSobolewskiRekrutacjaHRtec\Service;

use Symfony\Component\Yaml\Yaml;

class Config
{
    private static $configData;

    public static function getConfig(): array
    {
        if (!self::$configData) {
            $configPath = ROOT_DIR . DIRECTORY_SEPARATOR . "config.yml";
            self::$configData = Yaml::parseFile($configPath);
        }

        return self::$configData;
    }
}