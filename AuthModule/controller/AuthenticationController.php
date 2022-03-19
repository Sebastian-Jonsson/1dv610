<?php

namespace Controller;

class AuthenticationController {

    private $loginView;
    private $sessionHandler;
    private $loginModel;

    public function __construct(\View\LoginView $LV,
                                \Model\DAL\SessionHandling $SH,
                                \Model\LoginModel $LM) {

        $this->loginView = $LV;
        $this->sessionHandler = $SH;
        $this->loginModel = $LM;
    }

    public function attemptToLogin() : void {
        if ($this->loginView->userWantsToLogin()
            && !$this->sessionHandler->isLoggedIn()) 
        {
            try {
                $UserCredentials = new \Model\UserCredentials($this->loginView->getUsername(),
                                                            $this->loginView->getPassword(),
                                                            $this->loginView->getPassword());

                $this->loginModel->attemptToLogin($UserCredentials->getUsername(),
                                                $UserCredentials->getPassword());

                $this->loginView->nonReloadMessages(\View\Messages::WELCOME);
                
            } 
            catch (\Model\WrongUsernameOrPassword $e) {
                $this->loginView->nonReloadMessages(\View\Messages::WRONG_NAME_PASS);
            } 
            catch (\Model\UsernameLength $e) {
                $this->loginView->nonReloadMessages(\View\Messages::USERNAME_SHORT);
            } 
            catch (\Model\PasswordLength $e) {
                $this->loginView->nonReloadMessages(\View\Messages::PASSWORD_SHORT);
            }
            catch (\Model\PasswordMissing $e) {
                $this->loginView->nonReloadMessages(\View\Messages::PASSWORD_MISSING);
            } 
            catch (\Model\UsernameMissing $e) {
                $this->loginView->nonReloadMessages(\View\Messages::USERNAME_MISSING);
            }
        }
    }

    public function doLogout() : void {
        if ($this->loginView->userWantsToLogout() 
            && $this->sessionHandler->isLoggedIn()) 
        {
            $this->loginModel->userLogout();
            $this->loginView->nonReloadMessages(\View\Messages::BYES);
        }
    }

}