<?php

require __DIR__ . '/Config.php';

class PdoFactory
{
    public static function build()
    {
        try {
            $dbConfig = self::getConfig();
            return new PDO(self::getDsn(), $dbConfig->username, $dbConfig->password);
        } catch (PDOException $e) {
            echo "Error PDOException: " . $e->getMessage();
            die();
        }
    }

    private static function getDsn()
    {
        $dbConfig = self::getConfig();
        return "mysql:host=" . $dbConfig->host . ";dbname=" . $dbConfig->databasename;
    }

    private static function getConfig()
    {
        return (new Config())->db;
    }
}
