<?php

namespace Model;

class PictureURL {
	
	private static $MIN_URL_LENGTH = 10;
	private static $MAX_URL_LENGTH = 150;
	private $pictureUrl;

	public function __construct(string $pictureUrl)  {
		$this->pictureUrl = $this->urlValidity($pictureUrl);
	}
	
	public function getPictureUrl() : string {
		return $this->pictureUrl;
	}

	private function urlValidity($pictureUrl) : string {
		$this->disallowEmptyPictureUrl($pictureUrl);
		$this->checkValidLength($pictureUrl);
		$trimmedpictureUrl = trim($pictureUrl);
		return $trimmedpictureUrl;
	}

	private function checkValidLength($pictureUrl) : void {
        if (strlen($pictureUrl) < self::$MIN_URL_LENGTH
            && strlen($pictureUrl) > self::$MAX_URL_LENGTH) {
			throw new URLLength();
		}
	}

	private function disallowEmptyPictureUrl($pictureUrl) : void {
		if (empty(strlen($pictureUrl))) {
			throw new URLMissing();
		}
	}

	// TODO, fix to only allow image types from third party sources.
	private function confirmSourceType($pictureUrl) : void {
		if (strpos($pictureUrl, 'https://') == false) {
			throw new BadUrlString();
		}
	}
	
}