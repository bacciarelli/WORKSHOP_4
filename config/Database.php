<?php

namespace config;

class Database {
    
    private $connection;
    private static $instance;
    private $host = "localhost";
    private $username = "internet_shop";
    private $password = "coderslab";
    private $database = "internet_shop_db";

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->connection = new mysqli (
                $this->host,
                $this->username,
                $this->password,
                $this->database);
        
        if (mysqli_connect_error()) {
            trigger_error("Problem z połączeniem: " . mysqli_connect_error(), E_USER_ERROR);

        }
    }
    
    public function getConnection() {
        return $this->connection;
    }

}

?>