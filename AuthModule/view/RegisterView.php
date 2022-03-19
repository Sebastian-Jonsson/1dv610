<?php

namespace View;

class RegisterView {
	
	// TODO, cookie implementation.
	private static $cookieName = 'RegisterView::CookieName';
	private static $cookiePassword = 'RegisterView::CookiePassword';

	private static $register = 'RegisterView::Register';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $messageId = 'RegisterView::Message';
	private static $messageDetails = "";
	private static $formName = "";
	
	private $sessionHandler;

	public function __construct(\Model\DAL\SessionHandling $SH) {

		$this->sessionHandler = $SH;
	}

	public function pageReloader() : void {
		header("Location: /");
	}

	public function response() : string {
		return $this->confirmContent();
	}

	private function confirmContent() : string {
		$this->reloadMessages();
		$this->disallowEmptyFormFields();
		$this->saveFormNameInput();

		$response = $this->generateRegisterFormHTML();

		return $response;
	}
	
	private function generateRegisterFormHTML() : string {
		return '
		<a href="/">Back to login</a>
            <h2>Register new user</h2>
			<form action="?register" method="post" enctype="multipart/formdata">
				<fieldset>
					<legend>Register - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . self::$messageDetails . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . self::$formName . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$passwordRepeat . '">Repeat password  :</label>
					<input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" />
					
					<input type="submit" name="' . self::$register . '" value="register" />
				</fieldset>
			</form>
		';
	}

	private function saveFormNameInput() : void {
		if (isset($_POST[self::$name])) {
			self::$formName = strip_tags($_POST[self::$name]);
		}
	}

	private function disallowEmptyFormFields() : void {
		if ($this->userWantsToRegister()) {
			if (empty($_POST[self::$name]) 
				&& empty($_POST[self::$password]) 
				&& empty($_POST[self::$passwordRepeat])) 
			{
				self::$messageDetails = \View\Messages::BAD_REG_CREDENTIALS;
			}

			self::$formName = strip_tags($_POST[self::$name]);
		}
	}

	public function userWantsToRegister() : bool {
		return isset($_POST[self::$register]);
	}
	
	// Survives single page reload.
	public function reloadMessages() : void {
		if ($this->sessionHandler->isMessageSet()) {
			self::$messageDetails = $this->sessionHandler->getMessage();
		}
	}
	
	// Does not survive page reload.
	public function nonReloadMessages($nonRldMsg) : void {
		self::$messageDetails = $nonRldMsg;
	}
	
	public function getUsername() : \Model\Username {
		return new \Model\Username($_POST[self::$name]);
	}

	public function getPassword() : \Model\Password {
		return new \Model\Password($_POST[self::$password]);
	}

	public function getRepeatPassword() : \Model\Password {
		return new \Model\Password($_POST[self::$passwordRepeat]);
	}
	
}