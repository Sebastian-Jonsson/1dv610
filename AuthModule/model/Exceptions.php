<?php

namespace Model;

class WrongUsernameOrPassword extends \Exception{}

class UserExists extends \Exception{}

class InvalidCharacters extends \Exception{}

class UsernameLength extends \Exception{};

class PasswordLength extends \Exception{};

class PasswordMissing extends \Exception{};

class UsernameMissing extends \Exception{};

class NoPasswordMatch extends \Exception{};

class BadUrlString extends \Exception{};
