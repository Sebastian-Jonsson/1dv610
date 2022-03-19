<?php

namespace Controller;

require_once('ToPictureIt/view/ToPictureItView.php');
require_once('ToPictureIt/view/TPIMessages.php');

require_once('ToPictureItController.php');

require_once("ToPictureIt/model/DAL/TPIDatabase.php");
require_once("ToPictureIt/model/PictureInfos.php");

require_once('ToPictureIt/model/ToPictureItModel.php');
require_once('ToPictureIt/model/TPIExceptions.php');

class MainToPictureItController {

    private $database;
    private $toPictureItModel;
    private $toPictureItView;
    private $toPictureItController;
    
    public function __construct() {
        
        $this->DALModels();
        $this->pictureItModels();
        $this->toPictureItView = new \View\ToPictureItView();

        $this->toPictureItController = new \Controller\ToPictureItController($this->toPictureItView,
                                                                            $this->toPictureItModel);
    }
    
    public function getOutput() : string {
        $this->changeState();
        return $this->generateOutput();
    }

    private function changeState() : void {
        $this->toPictureItController->attemptToAddPicture();
        $this->toPictureItController->getPictures();
        $this->toPictureItController->removePicture();
    }
    
    private function generateOutput() : string {
        return $this->toPictureItView->response();
    }

    private function DALModels() : void {
        $this->database = new \Model\DAL\TPIDatabase();
    }

    private function pictureItModels() : void {
        $this->toPictureItModel = new \Model\ToPictureItModel($this->database);
    }

}