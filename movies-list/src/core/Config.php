<?php

class Config
{

    private $configFile = __DIR__ . "/../../config.php";
    public $db;

    public function __construct()
    {
        $this->db = require $this->configFile;
    }
}
