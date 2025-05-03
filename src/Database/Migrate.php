<?php

namespace PasswordGen\Database;

use Dotenv\Dotenv;
use PDOException;
use Exception;
use PDO;

// Cria uma instância do Dotenv
$dotenv = Dotenv::createImmutable(realpath(__DIR__ . '/../'));
// Carrega as variáveis do arquivo .env
$dotenv->load();

class Migrate
{
    public function makeMigrations(): string
    {

        $database = $_ENV['DB_DATABASE'];
        $query_verify_database = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'";

        $query_created_table = "CREATE TABLE passwords (
        id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
        password text NOT NULL,
        site text NOT NULL
        )";

        $host = $_ENV['DB_HOSTNAME'];
        $options = [
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $connection = new PDO("mysql:host=$host", $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $options);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $connection->query($query_verify_database);
        if (!$stmt->fetchColumn()) {
            $query_created_database = "CREATE DATABASE {$_ENV['DB_DATABASE']}";
            $connection->query($query_created_database);
        }
        $connection = new ConnectionDB($_ENV['DB_HOSTNAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE']);
        $cnx = $connection->connect();
        if (!$cnx) {
            return "\033[31mUnable to connect to the database.\033[0m\n";
        }
        try {
            $stmt1 = $cnx->prepare($query_created_table);
            $stmt1->execute();
            return "\033[32mMigrations performed successfully.\033[0m\n";
        } catch (PDOException | Exception $e) {
            // Registre o erro e relance a exceção
            error_log("\033[31m".$e->getMessage()."\033[0m");
            die;
        }
    }
}