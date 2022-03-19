<?php

namespace Model\DAL;

class Database {

    private static $dblocalhost = 'localhost';
    private static $dbusername = 'root';
    private static $dbpassword = 'root';
    private static $db = 'users';
    
    private static $connFail = 'Connection failed: ';

    private $hostname;
    private $username;
    private $password;
    private $database;

    public function __construct() {

        $this->localOrProductionServer();
    }

    public function connect() {
        $conn = mysqli_connect($this->hostname,
                                $this->username,
                                $this->password,
                                $this->database);

        if ($conn->connect_error) {
            die(self::$connFail . $conn->connect_error);
        }

        return $conn;
    }

    private function localOrProductionServer() : void {
        if (($_SERVER['SERVER_NAME']) == self::$dblocalhost) {
            $this->hostname = self::$dblocalhost;
            $this->username = self::$dbusername;
            $this->password = self::$dbpassword;
            $this->database = self::$db;
        } 
        else {
            $url = getenv('JAWSDB_URL');
    
            $dbparts = parse_url($url);
    
            $this->hostname = $dbparts['host'];
            $this->username = $dbparts['user'];
            $this->password = $dbparts['pass'];
            $this->database = ltrim($dbparts['path'],'/');
        }
    }

    // TODO, consider implementation for DRY purposes if application grows.
    public function databaseSqlQuery($sqlSelection) {
        return $this->connect()->query($sqlSelection);
    }

}