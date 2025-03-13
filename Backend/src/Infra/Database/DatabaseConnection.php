<?php

namespace Fulll\Infra\Database;

use PDO;
use PDOException;
use Fulll\Infra\Config\Config;

class DatabaseConnection
{
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getInstance(bool $DbName = false): PDO
    {
        if (self::$instance === null) {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s',
                Config::get('DB_HOST'),
                $DbName ? Config::get('DB_NAME') : ''
            );

            try {
                self::$instance = new PDO($dsn, Config::get('DB_USER'), Config::get('DB_PASSWORD'));
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new \RuntimeException("Error while connecting to the database : " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}