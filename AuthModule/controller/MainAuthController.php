<?php

namespace Controller;

require_once('AuthModule/view/LoginView.php');
require_once('AuthModule/view/RegisterView.php');
require_once('AuthModule/view/DateTimeView.php');
require_once('AuthModule/view/LayoutView.php');
require_once('AuthModule/view/Messages.php');

require_once('AuthenticationController.php');
require_once('RegisterController.php');

require_once("AuthModule/model/DAL/Database.php");
require_once("AuthModule/model/DAL/SessionHandling.php");

require_once('AuthModule/model/LoginModel.php');
require_once('AuthModule/model/RegisterModel.php');
require_once('AuthModule/model/Exceptions.php');
require_once('AuthModule/model/UserCredentials.php');

class MainAuthController {

    private $database;
    private $sessionHandling;
    private $loginModel;
    private $registerModel;
    private $authenticationController;
    private $registerController;
    
    private $loginView;
    private $layoutView;
    
    public function __construct($appModule) {

        $this->DALModels();
        $this->sessionHandling->startSession();
        
        $this->authModels();
        $this->authViews($appModule);

        $this->authenticationController = new \Controller\AuthenticationController($this->loginView,
                                                                                $this->sessionHandling,
                                                                                $this->loginModel);
        
        $this->registerController = new \Controller\RegisterController($this->registerView,
                                                                    $this->sessionHandling,
                                                                    $this->registerModel);
        
    }
    
    public function getOutput() : void {
        $this->changeState();
        $this->generateOutput();
    }

    private function generateOutput() : void {
        $this->layoutView = new \View\LayoutView($this->loginView,
                                                $this->dateTimeView,
                                                $this->registerView);
        $this->layoutView->renderStartPage();
    }

    private function changeState() : void {
        $this->authenticationController->attemptToLogin();
        $this->registerController->attemptToRegister();
        $this->authenticationController->doLogout();
    }

    private function DALModels() : void {
        $this->sessionHandling = new \Model\DAL\SessionHandling();
        $this->database = new \Model\DAL\Database();
    }

    private function authViews($appModule) : void {
        $this->loginView = new \View\LoginView($this->sessionHandling, $appModule);
        $this->registerView = new \View\RegisterView($this->sessionHandling);
        $this->dateTimeView = new \View\DateTimeView();
    }

    private function authModels() : void {
        $this->loginModel = new \Model\LoginModel($this->sessionHandling,
                                                    $this->database);
        $this->registerModel = new \Model\RegisterModel($this->sessionHandling,
                                                        $this->database);
    }

}