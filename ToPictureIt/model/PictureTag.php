<?php

namespace Model;

class PictureTag {
	
	private static $MIN_TAG_LENGTH = 2;
	private static $MAX_TAG_LENGTH = 20;
	private $pictureTag;

	public function __construct(string $pictureTag)  {
		$this->pictureTag = $this->tagValidity($pictureTag);
	}
	
	// TODO: Fix to strip a-tags.
	private function tagValidity($pictureTag) : string {
		$this->disallowEmptyTag($pictureTag);
		$this->checkValidLength($pictureTag);
		$trimmedTag = trim($pictureTag);
		return $trimmedTag;
	}

	private function checkValidLength($pictureTag) : void {
        if (strlen($pictureTag) < self::$MIN_TAG_LENGTH
			&& strlen($pictureTag) > self::$MAX_TAG_LENGTH)
		{
			throw new TagLength();
		}
	}

	private function disallowEmptyTag($pictureTag) : void {
		if (empty(strlen($pictureTag))) {
			throw new TagMissing();
		}
	}
	
	public function getPictureTag() : string {
		return $this->pictureTag;
	}

}