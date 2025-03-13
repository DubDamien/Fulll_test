<?php

require_once __DIR__ . '/vendor/autoload.php';

use Fulll\Infra\Config\Config;
use Fulll\Infra\Database\DatabaseInitializer;
use Fulll\Infra\Database\DatabaseConnection;
use Fulll\Infra\Database\Migrations\MigrationManager;

try {
    Config::load(__DIR__ . '/.env');

    $connection = DatabaseConnection::getInstance();

    $initializer = new DatabaseInitializer($connection);
    $initializer->initDatabase();

    $migrationManager = new MigrationManager($connection);
    $migrationManager->applyMigrations();

    echo 'INFO', " Database successfully created.";
} catch (Exception $e) {
    echo 'ERROR', " Error while initialize the Database : " . $e->getMessage();
    exit(1);
}