<?php

namespace Model\DAL;

// TODO Not yet implemented
class ProductionSettings {
    
    public $hostname;
    public $username;
    public $password;
    public $database;

    public function __construct() {
        $url = getenv('JAWSDB_URL');
    
        $dbparts = parse_url($url);

        $this->hostname = $dbparts['host'];
        $this->username = $dbparts['user'];
        $this->password = $dbparts['pass'];
        $this->database = ltrim($dbparts['path'],'/');
    }


}