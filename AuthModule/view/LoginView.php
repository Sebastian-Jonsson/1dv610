<?php

namespace View;

class LoginView {
	
	// TODO, cookie implementation.
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';

	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $messageDetails = "";
	private static $formName = "";

	private $sessionHandler;
	private $appModule;

	public function __construct(\Model\DAL\SessionHandling $SH, 
								$appModule) {
									
		$this->sessionHandler = $SH;
		$this->appModule = $appModule;
	}
	
	public function response() : string {
		return $this->responseControl();
	}

	private function responseControl() : string {
		$this->reloadMessages();
		$this->saveFormNameInput();

		if ($this->sessionHandler->isLoggedIn()) {
			$response = $this->generateLoggedInHTML();
		}
		else if ($this->sessionHandler->isMessageSet()) {
			$response = $this->generateLoginFormHTML();
		}
		else {
			$response = $this->generateLoginFormHTML();
		}
		return $response;
	}

	private function generateLoggedInHTML() : string {
		return '
		<h2>Logged in</h2>
			<form  method="post" >
				<p id="' . self::$messageId . '">' . self::$messageDetails .' </p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
			' . $this->appModule . '
		';
	}
	
	private function generateLoginFormHTML() : string {
		return '
		<a href="?register">Register a new user</a>
      	<p>
      	<h2>Not logged in</h2>
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . self::$messageDetails . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . self::$formName . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
	
	private function saveFormNameInput() : void {
		if ($this->sessionHandler->isFormNameSet()) {
			self::$formName = $this->sessionHandler->getFormName();
		}
		else if (isset($_POST[self::$name])) {
			self::$formName = strip_tags($_POST[self::$name]);
		}
	}

	public function userWantsToLogin() : bool {
		return isset($_POST[self::$login]);
	}

	public function userWantsToLogout() : bool {
		return isset($_POST[self::$logout]);
	}

	// Survives single page reload.
	public function reloadMessages() : void {
		if ($this->sessionHandler->isMessageSet()) {
			self::$messageDetails = $this->sessionHandler->getMessage();
		}
	}

	// Does not survive page reload.
	public function nonReloadMessages(string $message) : void {
		self::$messageDetails = $message;		
	}
	
	public function getUsername() : \Model\Username {
		return new \Model\Username($_POST[self::$name]);
	}

	public function getPassword() : \Model\Password {
		return new \Model\Password($_POST[self::$password]);
	}

}