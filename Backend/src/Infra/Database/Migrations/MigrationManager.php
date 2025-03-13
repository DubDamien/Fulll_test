<?php

namespace Fulll\Infra\Database\Migrations;

use PDO;
use PDOException;

class MigrationManager
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function applyMigrations(): void
    {
        $this->createMigrationsTable();

        $appliedMigrations = $this->getAppliedMigrations();

        $migrationFiles = glob(__DIR__ . '/*.sql');

        foreach ($migrationFiles as $migrationFile) {
            $migrationName = basename($migrationFile);

            if (!in_array($migrationName, $appliedMigrations)) {
                $sql = file_get_contents($migrationFile);

                try {
                    $this->connection->exec($sql);
                    $this->saveMigration($migrationName);
                } catch (PDOException $e) {
                    throw new \RuntimeException("Error while apply the migration $migrationName : " . $e->getMessage());
                }
            }
        }
    }

    private function createMigrationsTable(): void
    {
        $this->connection->exec("
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255) NOT NULL,
                applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;
        ");
    }

    private function getAppliedMigrations(): array
    {
        $stmt = $this->connection->query("SELECT migration FROM migrations");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function saveMigration(string $migrationName): void
    {
        $stmt = $this->connection->prepare("INSERT INTO migrations (migration) VALUES (:migration)");
        $stmt->execute(['migration' => $migrationName]);
    }
}