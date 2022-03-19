<?php

namespace Model\EXPERIMENTAL;

require_once('LocalhostSettings.php');
require_once('ProductionSettings.php');

// TODO: Swap out old databases once operational.
class ExperimentalDatabase {

    
    private $hostname;
    private $username;
    private $password;
    private $database;
    private $settings;

    public function __construct() {
        
        $this->localOrProductionServer();
    }

    public function localOrProductionServer() : void {
        if (($_SERVER['SERVER_NAME']) == 'localhost') {
            $this->settings = new \Model\DAL\LocalhostSettings();
            
            $this->hostname = $this->settings->hostname;
            $this->username = $this->settings->username;
            $this->password = $this->settings->password;
            $this->database = $this->settings->database;
        } 
        else {
            $this->settings = new \Model\DAL\ProductionSettings();

            $this->hostname = $this->settings->hostname;
            $this->username = $this->settings->username;
            $this->password = $this->settings->password;
            $this->database = $this->settings->database;
        }
    }


    public function connect() {
        $conn = mysqli_connect($this->hostname,
                                $this->username,
                                $this->password,
                                $this->database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    // TODO: Fix, PHP Does not find $this->settings publics.
    private function setConnection() {
        $this->hostname = $this->settings->hostname;
        $this->username = $this->settings->username;
        $this->password = $this->settings->password;
        $this->database = $this->settings->database;
    }

    // TODO, implement or remove
    public function databaseSqlQuery($sqlSelection) {
        return $this->connect()->query($sqlSelection);
    }

}