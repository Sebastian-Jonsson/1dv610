<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('AuthModule/controller/MainAuthController.php');
require_once('ToPictureIt/controller/MainToPictureItController.php');

/** TODO:
 * Fix that can be done regarding Exceptions is to gather them in one module
 * create a view for just errors and general messages. Lack of time.
 * Add Session Hijacking protection through browser and/or ip conflicts.
 * Fix the a-tag insertions.
 */

$toPictureIt = new \Controller\MainToPictureItController();
$authModule = new \Controller\MainAuthController($toPictureIt->getOutput());
$authModule->getOutput();




