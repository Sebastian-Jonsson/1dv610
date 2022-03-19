<?php

namespace Model;

class PictureDescription {
	
	private static $MIN_DESC_LENGTH = 5;
	private static $MAX_DESC_LENGTH = 250;
	private $description;

	public function __construct(string $description)  {
		
		$this->description = $this->descriptionValidity($description);
	}
	
	// TODO: Fix to strip a-tags.
	private function descriptionValidity($description) : string {
		$this->disallowEmptyDescription($description);
		$this->checkValidLength($description);
		$trimmeddescription = trim($description);
		return $trimmeddescription;
	}

	private function checkValidLength($description) : void {
        if (strlen($description) < self::$MIN_DESC_LENGTH
		&& strlen($description) > self::$MAX_DESC_LENGTH) 
		{
			throw new DescriptionLength();
		}
	}

	private function disallowEmptyDescription($description) : void {
		if (empty(strlen($description))) {
			throw new DescriptionMissing();
		}
	}
	
	public function getPictureDescription() : string {
		return $this->description;
	}

}