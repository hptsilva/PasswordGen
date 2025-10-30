<?php

namespace PasswordGen\Database;

use Dotenv\Dotenv;
use PDOException;
use Exception;
use PDO;

$dotenv = Dotenv::createImmutable(getcwd());
$dotenv->load();

class Migrate
{
    public function makeMigrations(): string
    {

        $database = $_ENV['DB_DATABASE'];
    
        $query_created_table = "CREATE TABLE passwords (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        password TEXT NOT NULL,
        site text TEXT NULL
        )";

        $connection = new PDO("sqlite:$database.sqlite");
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {
            $stmt1 = $connection->prepare($query_created_table);
            $stmt1->execute();
            return "\033[32mMigrations performed successfully.\033[0m\n";
        } catch (PDOException | Exception $e) {
            error_log("\033[31m".$e->getMessage()."\033[0m");
            die;
        }
    }
}