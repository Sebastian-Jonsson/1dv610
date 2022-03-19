<?php

namespace Model;

class Username {
	
	private static $MIN_USERNAME_LENGTH = 3;
	private $name;

	public function __construct(string $username)  {
		
		$this->name = $this->usernameValidity($username);
	}

	private function usernameValidity($name) : string {
		$this->disallowEmptyName($name);
		$this->confirmValidLength($name);
		$trimmedName = trim($name);
		return $trimmedName;
	}

	private function confirmValidLength($name) : void {
		if (strlen($name) < self::$MIN_USERNAME_LENGTH) {
			throw new UsernameLength();
		}
	}

	private function disallowEmptyName($name) : void {
		if (empty(strlen($name))) {
			throw new UsernameMissing();
		}	
	}

	public function getUsername() : string {
		return $this->name;
	}

}