<?php

namespace Controller;

class RegisterController {

    private $registerView;
    private $sessionHandler;
    private $registerModel;

    public function __construct(\View\RegisterView $RV, 
                                \Model\DAL\SessionHandling $SH,
                                \Model\RegisterModel $RM) {
                                    
        $this->registerView = $RV;
        $this->sessionHandler = $SH;
        $this->registerModel = $RM;
    }

    public function attemptToRegister() : void {
        if ($this->registerView->userWantsToRegister()
            && !$this->sessionHandler->isLoggedIn()) 
        {
            try {
                $UserCredentials = new \Model\UserCredentials($this->registerView->getUsername(),
                                                            $this->registerView->getPassword(),
                                                            $this->registerView->getRepeatPassword());

                $this->registerModel->attemptToRegister($UserCredentials->getUsername(),
                                                        $UserCredentials->getPassword());

                $this->registerView->pageReloader();
                $this->registerModel->successfulRegistration($UserCredentials->getUsername());

            } 
            catch (\Model\UserExists $e) {
                $this->registerView->nonReloadMessages(\View\Messages::USER_EXISTS);
            } 
            catch (\Model\NoPasswordMatch $e) {
                $this->registerView->nonReloadMessages(\View\Messages::BAD_REG_PWD_MATCH);
            } 
            catch (\Model\PasswordMissing | \Model\PasswordLength $e) {
                $this->registerView->nonReloadMessages(\View\Messages::BAD_REG_PWD);
            } 
            catch (\Model\UsernameMissing | \Model\UsernameLength $e) {
                $this->registerView->nonReloadMessages(\View\Messages::BAD_REG_NAME);
            } 
            catch (\Model\InvalidCharacters $e) {
                $this->registerView->nonReloadMessages(\View\Messages::INVALID_CHARS);
            }
        }
    }

}