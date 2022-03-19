<?php

namespace Model;

require_once('PictureURL.php');
require_once('PictureDescription.php');
require_once('PictureTag.php');

class PictureInfos {

    private $pictureURL;
    private $pictureDescription;
    private $pictureTag;

    public function __construct(\Model\PictureURL $PURL,
                                \Model\PictureDescription $PDesc,
                                \Model\PictureTag $PTag) {
                                    
        $this->pictureURL = $PURL;
        $this->pictureDescription = $PDesc;
        $this->pictureTag = $PTag;
    }

    public function getPictureURL() : string {
        return $this->pictureURL->getPictureURL();
    }

    public function getPictureDescription() : string {
        return $this->pictureDescription->getPictureDescription();
    }

    public function getPictureTag() : string {
        return $this->pictureTag->getPictureTag();
    }
    
}