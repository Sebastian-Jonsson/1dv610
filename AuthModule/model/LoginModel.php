<?php

namespace Model;

class LoginModel {

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

    public function attemptToLogin(string $username, string $password) : void {
        $sql = $this->sqlSelectUsername($username);
        $row = $this->databaseQuery($sql)->fetch_assoc();
        
        if ($row[self::$rowUsername] == $username
        && $this->confirmHashPassword($row[self::$rowPassword], $password)) 
        {
            $this->sessionHandler->setLoggedIn($username);
            $this->sessionHandler->removeMessage();
        }
        else {
            throw new WrongUsernameOrPassword();
        }
    }

    public function userLogout() : void {
        $this->sessionHandler->isLoggedOut();
    }

    private function databaseQuery($sqlSelection) : object {
        return $this->database->connect()->query($sqlSelection);
    }

    private function sqlSelectUsername($username) : string {
        return "SELECT * FROM " . self::$tableName . " 
        WHERE " . self::$rowUsername . "='$username'";
    }
    
    private function confirmHashPassword($hashPass, $password) : string {
        return password_verify($password, $hashPass);
    }

}