<?php

namespace Model\DAL;

class SessionHandling {

    private static $username = 'username';
    private static $message = 'message';
    private static $formName = 'formName';
    //TODO: browserType and userAgent not implemented.
    private static $browserType= 'browsertype';
    private static $userAgent = 'HTTP_USER_AGENT';

    public function startSession() : void {
        session_start();
    }
    

    // Username handling
    public function isLoggedIn() : bool {
        return isset($_SESSION[self::$username]);
    }

    public function setLoggedIn($name) : void {
        $_SESSION[self::$username] = $name;
    }

    public function isLoggedOut() : void {
        unset($_SESSION[self::$username]);
    }
    

    // Messages to survive a reload through session.
    public function isMessageSet() : bool {
        return isset($_SESSION[self::$message]);
    }

    public function getMessage() : string {
        return $_SESSION[self::$message];
    }

    public function setMessage($message) : void {
        $_SESSION[self::$message] = $message;
    }

    public function removeMessage() : void {
        unset($_SESSION[self::$message]);
    }
    

    // Temporary Form Name session functions.
    public function getFormName() : string {
       return $_SESSION[self::$formName];
    }
    
    public function setFormName($name) : void {
        $_SESSION[self::$formName] = $name;
    }

    public function isFormNameSet() : bool {
        return isset($_SESSION[self::$formName]);
    }

    
    //TODO get operational and receive userAgent info from view.
    private function setSessionBrowserExperiment() : void {
        $_SESSION[self::$browserType] = $_SERVER[self::$userAgent];
    }

    //TODO make a proper validation.
    private function getSessionBrowserExperiment() : bool {
        if (isset($_SESSION[self::$browserType])) {
            if ($_SESSION[self::$browserType] != $_SERVER[self::$userAgent]);
            return false;
        }
    }
    
    //TODO proper validation.
    private function isLoggedInExperiment() : bool {
        if ($_SESSION[self::$browserType] == $_SERVER[self::$userAgent]) {
            return isset($_SESSION[self::$username]);
        }
        else {
            return false;
        }
    }

}