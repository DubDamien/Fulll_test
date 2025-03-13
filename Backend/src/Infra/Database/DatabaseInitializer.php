<?php

namespace Fulll\Infra\Database;

use PDO;
use PDOException;
use Fulll\Infra\Config\Config;

class DatabaseInitializer
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function initDatabase(): void
    {
        try {
            $this->connection->exec("CREATE DATABASE IF NOT EXISTS " . Config::get('DB_NAME'));
            $this->connection->exec("USE " . Config::get('DB_NAME'));
        } catch (PDOException $e) {
            throw new \RuntimeException("Error while creating the database : " . $e->getMessage());
        }
    }
}