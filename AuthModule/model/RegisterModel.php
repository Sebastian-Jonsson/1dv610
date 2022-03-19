<?php

namespace Model;

class RegisterModel {

    private static $tableName = "userlist";
    private static $rowUsername = "username";
    private static $rowPassword = "password";

    private $sessionHandler;
    private $database;

    public function __construct(\Model\DAL\SessionHandling $SH,
                                \Model\DAL\Database $DB) {
                                    
        $this->sessionHandler = $SH;
        $this->database = $DB;
    }

    public function attemptToRegister(string $username, string $password) : void {
        if ($this->allowedSymbolsCheck($username)) {
            $nameSql = $this->sqlSelectUsername($username);
            $row = $this->databaseQuery($nameSql)->fetch_assoc();

            if ($row[self::$rowUsername] != $username) {
                $password = $this->createHashPassword($password);
                $insertSql = $this->sqlInsertUser($username, $password);
                $this->databaseQuery($insertSql);
                
            }
            else if ($row[self::$rowUsername] == $username) {
                throw new UserExists();
            }
        }
        else {
            throw new InvalidCharacters();
        }
    }

    public function successfulRegistration($username) : void {
        $this->sessionHandler->setFormName($username);
        $this->sessionHandler->setMessage(\View\Messages::NEW_USER);
    }

    private function databaseQuery($sqlSelection) {
        return $this->database->connect()->query($sqlSelection);
    }
    
    private function sqlSelectUsername($username) : string {
        return "SELECT * FROM " . self::$tableName . " 
        WHERE " . self::$rowUsername . "='$username'";
    }

    private function sqlInsertUser($username, $password) : string {
        return "INSERT INTO " . self::$tableName . " 
        (" . self::$rowUsername . ", " . self::$rowPassword . ") 
        VALUES ('$username', '$password')";
    }
    
    private function createHashPassword($password) : string {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private function allowedSymbolsCheck(string $username) : int {
        return preg_match('/^[A-Za-z][A-Za-z0-9]{1,31}$/', $username);
    }

}