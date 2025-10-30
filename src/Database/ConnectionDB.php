<?php

namespace PasswordGen\Database;
use PDOException;
use PDO;

class ConnectionDB
{

    public static function connect(): false|PDO
    {
        try {
            $database = $_ENV['DB_DATABASE'];
            $connection = new PDO("sqlite:$database.sqlite");
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $connection;
        } catch (PDOException) {
            return false;
        }
    }

    public static function insertPassword(string $password, string $site, PDO $cnx): bool
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

    public static function searchPassword(int $id, PDO $cnx): bool
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

    public static function deletePassword(int $id, PDO $cnx): bool
    {
        try {
            if (!self::searchPassword($id, $cnx)) {
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

    public static function updateSite(int $id, string $site, PDO $cnx): bool
    {
        try {
            if (!self::searchPassword($id, $cnx)) {
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

    public static function listPasswords(PDO $cnx): array|bool
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