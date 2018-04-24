<?php

class Conexion
{
	
	public static function getPDO()
	{
		try {
            $dbConfig = self::getConfig();
            $dsn = "mysql:host=" . $dbConfig['host'] . ";dbname=" . $dbConfig['basename'];
            return new PDO($dsn, $dbConfig['user'], $dbConfig['pass']);
        } catch (PDOException $e) {
            echo "Error PDOException: " . $e->getMessage();
            die();
        }
	}

	private static function getConfig()
	{
		$dbConfig = [
			'host' => '',
			'user' => '',
			'pass' => '',
			'basename' => ''
		];
		$dom = new DOMDocument;
		$dom->load('Parametros.xml');
		$dbConfig['host'] = $dom->getElementsByTagName('host')->item(0)->nodeValue;
		$dbConfig['user'] = $dom->getElementsByTagName('user')->item(0)->nodeValue;
		$dbConfig['pass'] = $dom->getElementsByTagName('pass')->item(0)->nodeValue;
		$dbConfig['basename'] = $dom->getElementsByTagName('base')->item(0)->nodeValue;
		return $dbConfig;
	}

}

	
