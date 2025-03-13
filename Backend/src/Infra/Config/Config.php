<?php

namespace Fulll\Infra\Config;

use Symfony\Component\Dotenv\Dotenv;

class Config
{
    private static array $config = [];

    public static function load(string $path): void
    {
        if (!file_exists($path)) {
            throw new \RuntimeException("File .env does not exist.");
        }

        $dotenv = new Dotenv();
        $dotenv->load($path);

        self::$config = $_ENV;
    }

    public static function get(string $key, $default = null)
    {
        return self::$config[$key] ?? $default;
    }
}