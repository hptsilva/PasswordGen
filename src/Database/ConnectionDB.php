<?php

namespace PasswordGen\Database;
use PDO;
use PDOException;

class ConnectionDB
{

    private $hostname, $username, $password, $database;

    public function __construct($hostname, $username, $password, $database)
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function connect(): false|PDO
    {
        try {

            $options = [
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            return new PDO("mysql:host=$this->hostname;dbname=$this->database;charset=utf8mb4", $this->username, $this->password, $options);
        } catch (PDOException) {
            return false;
        }
    }

    public function insertPassword(string $password, string $site, PDO $cnx): bool
    {
        try{
            $query = "INSERT INTO passwords (password, site) VALUES (:password, :site)";
            $stmt = $cnx->prepare($query);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':site', $site);
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        return True;
    }

    public function searchPassword(int $id, PDO $cnx): bool
    {
        try {
            $query = "SELECT * FROM passwords WHERE id = :id";
            $stmt = $cnx->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $response = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($response) {
                return True;
            } else {
                return false;
            }
        } catch (PDOException) {
            return false;
        }
    }

    public function deletePassword(int $id, PDO $cnx): bool
    {
        try {
            if (!$this->searchPassword($id, $cnx)) {
                return false;
            }
            $query = "DELETE FROM passwords WHERE id = :id";
            $stmt = $cnx->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        return True;
    }

    public function updateSite(int $id, string $site, PDO $cnx): bool
    {
        try {
            if (!$this->searchPassword($id, $cnx)) {
                return false;
            }
            $query = "UPDATE passwords SET site = :site WHERE id = :id";
            $stmt = $cnx->prepare($query);
            $stmt->bindParam(':site', $site);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException) {
            return false;
        }
        return True;
    }

    public function listPasswords(PDO $cnx): array|bool
    {
        try {
            $query = "SELECT * FROM passwords";
            $stmt = $cnx->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException) {
            return false;
        }
    }
}