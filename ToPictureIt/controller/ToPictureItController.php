<?php

namespace Controller;

class ToPictureItController {

    private $toPictureItView;
    private $toPictureItModel;

    public function __construct(\View\ToPictureItView $TPIV,
                                \Model\ToPictureItModel $TPIM) {
                                    
        $this->toPictureItView = $TPIV;
        $this->toPictureItModel = $TPIM;
    }

    public function attemptToAddPicture() : void {
        if ($this->toPictureItView->userWantsToAddPicture()) 
        {
            try {
                $pictureInfos = new \Model\PictureInfos($this->toPictureItView->getPictureUrl(),
                                                            $this->toPictureItView->getDescription(),
                                                            $this->toPictureItView->getPictureTag());

                $this->toPictureItModel->attemptToAddPicture($pictureInfos->getPictureUrl(),
                                                            $pictureInfos->getPictureDescription(),
                                                            $pictureInfos->getPictureTag());

                $this->toPictureItView->allMessages(\View\TPIMessages::ADDED_TO_PICTURE_IT);

            } 
            catch (\Model\TagLength $e) {
                $this->toPictureItView->allMessages(\View\TPIMessages::TAG_LENGTH);
            } 
            catch (\Model\TagMissing $e) {
                $this->toPictureItView->allMessages(\View\TPIMessages::TAG_MISSING);
            } 
            catch (\Model\URLLength $e) {
                $this->toPictureItView->allMessages(\View\TPIMessages::URL_LENGTH);
            } 
            catch (\Model\URLMissing $e) {
                $this->toPictureItView->allMessages(\View\TPIMessages::URL_MISSING);
            } 
            catch (\Model\DescriptionLength $e) {
                $this->toPictureItView->allMessages(\View\TPIMessages::DESCRIPTION_LENGTH);
            } 
            catch (\Model\DescriptionMissing $e) {
                $this->toPictureItView->allMessages(\View\TPIMessages::DESCRIPTION_MISSING);
            } 
            catch (\Model\InvalidToPictureItCharacters $e) {
                $this->toPictureItView->allMessages(\View\TPIMessages::INVALID_PICTURE_CHARACTERS);
            }  
            catch (\Model\URLExists $e) {
                $this->toPictureItView->allMessages(\View\TPIMessages::URL_EXISTS);
            }
            catch (\Model\BadUrlString $e) {
                $this->toPictureItView->allMessages(\View\TPIMessages::BAD_URL_STRING);
            }
        }
    }

    public function getPictures() : void {
        $allPictureIts = $this->toPictureItModel->getAllPictureIts();
        $this->toPictureItView->getPictureItsList($allPictureIts);
    }

    //TODO fix -> Usecase fulfilled regardless since there are two ways that present the update.
    public function removePicture() : void {
        if ($this->toPictureItView->userWantsToRemovePicture()) 
        {
            $tempID = $this->toPictureItView->removalID();
            $this->toPictureItModel->attemptToRemovePicture($tempID);
            
            $this->toPictureItView->pageReloader();
            $this->toPictureItView->allMessages(\View\TPIMessages::REMOVED_TO_PICTURE_IT);
        }
    }

    // TODO: Add edit function.
    private function editPictureIt() : void {

    }

    // TODO: Add search tags function.
    private function searchPictureItTag() : void {

    }

}