<?php

namespace Model;

class Password {
	
	private static $MIN_PASSWORD_LENGTH = 6;
	private $password;

	public function __construct(string $password)  {
		$this->password = $this->passwordValidity($password);
	}
	
	private function passwordValidity($password) : string {
		$this->disallowEmptyPassword($password);
		$this->checkValidLength($password);
		$trimmedPassword = trim($password);
		return $trimmedPassword;
	}

	private function checkValidLength($password) : void {
		if (strlen($password) < self::$MIN_PASSWORD_LENGTH) {
			throw new PasswordLength();
		}
	}

	private function disallowEmptyPassword($password) : void {
		if (empty(strlen($password))) {
			throw new PasswordMissing();
		}
	}
	
	public function getPassword() : string {
		return $this->password;
	}

}