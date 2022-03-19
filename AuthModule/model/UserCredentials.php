<?php

namespace Model;

require_once('Username.php');
require_once('Password.php');

class UserCredentials {

    private $username;
    private $password;

    public function __construct(\Model\Username $username,
                                \Model\Password $password,
                                \Model\Password $repeatPassword) {
                                    
        $this->username = $username;
        $this->password = $password;
        
        if ($password != $repeatPassword) {
            throw new NoPasswordMatch();
        }
    }

    public function getUsername() : string {
        return $this->username->getUsername();
    }

    public function getPassword() : string {
        return $this->password->getPassword();
    }
    
}