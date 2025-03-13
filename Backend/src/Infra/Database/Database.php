<?php

namespace Fulll\Infra\Database;

use Symfony\Component\Dotenv\Dotenv;
use PDO;
use PDOException;

class Database {

    private string $dbname;
    private string $host;
    private string $username;
    private string $password;
    
    public function initDb() {
        $dotenv = new Dotenv();

        $this->dbname = $_ENV['DB_NAME'];
        $this->host = $_ENV['DB_HOST'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];

        try {
            $pdo = new PDO("mysql:host=$this->host", $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            $pdo->exec("CREATE DATABASE IF NOT EXISTS $this->dbname");
            $pdo->exec("USE $this->dbname");
        
            $sql = file_get_contents('/Database.sql');
            $pdo->exec($sql);
        
            echo "Database and tables successfully created.";
        } catch (PDOException $e) {
            die("Error while creating the database : " . $e->getMessage());
        }
    }
}

