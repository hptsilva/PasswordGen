<?php

namespace PasswordGen\Class;

use PasswordGen\Exceptions\InvalidID;
use PasswordGen\Exceptions\InvalidLength;
use PasswordGen\Database\ConnectionDB;
use PDOException;
use Random\RandomException;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(realpath(__DIR__ . '/../'));
$dotenv->load();
class Password
{

    /**
     * @param int $length
     * @param string $site
     * @return string
     * @throws InvalidLength
     * @throws RandomException
     */
    public function generate(int $length, string $site):string
    {
        if ($length < 0) {
            throw new InvalidLength('Password length must be a positive number');
        }

        if (strlen($site) == 0) {
            throw new InvalidLength('Site name cannot be empty.');
        }

        $numbers = range(0, 9);
        $lowerCase = range('a', 'z');
        $capitalCase = range('A', 'Z');
        $specialChars = ['!', '@', '#', '$', '%', '^', '&', '*', '-', '_', '=', '+'];
        $mergedChars = array_merge($numbers, $lowerCase, $capitalCase, $specialChars);

        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $randomIndex = random_int(0, count($mergedChars) - 1);
            $password .= $mergedChars[$randomIndex];
        }

        $connectionDB = new ConnectionDB($_ENV['HOSTNAME'], $_ENV['USER'], $_ENV['PASSWORD'], $_ENV['DATABASE']);
        $cnx = $connectionDB->connect();
        if (!$cnx) {
            throw new PDOException('Cannot connect to database');
        }

        $insert = $connectionDB->insertPassword($password, $site, $cnx);
        if (!$insert) {
            throw new PDOException('Cannot create password');
        }

        return "\033[32mPassword created successfully.\033[0m\n$password";

    }

    /**
     * @param int $id
     * @throws InvalidID
     */
    public function deletePassword(int $id):string
    {

        if ($id < 1) {
            throw new InvalidID('Invalid ID');
        }

        $connectionDB = new ConnectionDB($_ENV['HOSTNAME'], $_ENV['USER'], $_ENV['PASSWORD'], $_ENV['DATABASE']);
        $cnx = $connectionDB->connect();

        if (!$cnx) {
            throw new PDOException('Cannot connect to database');
        }

        if (!$connectionDB->deletePassword($id, $cnx)) {
            return "\033[31mError to delete password.\033[0m";

        }

        return "\033[32mPassword deleted.\033[0m";

    }

    /**
     * @throws InvalidID
     * @throws InvalidLength
     */
    public function updateSite(int $id, string $site):string
    {
        if ($id < 1) {
            throw new InvalidID('Invalid ID');
        }

        if (strlen($site) == 0) {
            throw new InvalidLength('Site name cannot be empty.');
        }

        $connectionDB = new ConnectionDB($_ENV['HOSTNAME'], $_ENV['USER'], $_ENV['PASSWORD'], $_ENV['DATABASE']);
        $cnx = $connectionDB->connect();

        if (!$cnx) {
            throw new PDOException('Cannot connect to database');
        }

        if (!$connectionDB->updateSite($id, $site, $cnx)) {
            return "\033[31mError to update site name.\033[0m";
        }

        return "\033[32mSite name updated.\033[0m";
    }

    public function listPasswords():array|string
    {
        $connectionDB = new ConnectionDB($_ENV['HOSTNAME'], $_ENV['USER'], $_ENV['PASSWORD'], $_ENV['DATABASE']);
        $cnx = $connectionDB->connect();
        if (!$cnx) {
            throw new PDOException('Cannot connect to database');
        }

        return $connectionDB->listPasswords($cnx);
    }
}
