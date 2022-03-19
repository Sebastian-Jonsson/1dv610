<?php

namespace View;

class LayoutView {

  private static $registerButton = 'register';
  
  private $loginView;
  private $dateTimeView;
  private $registerView;

  public function __construct(LoginView $LV,
                              DateTimeView $DTV,
                              RegisterView $RV) {
    
    $this->loginView = $LV;
    $this->dateTimeView = $DTV;
    $this->registerView = $RV;
  }
  
  public function renderStartPage() : void {
    echo '
    <!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <link rel="stylesheet" href="base.css" type="text/css">
          <title>Assignment 3 - Login ToPictureIt</title>
        </head>
        <body>
          <h1>Assignment 3 - ToPictureIt</h1>
          
          <div class="authcontainer">
          ' . $this->swapLoginOrRegisterView() . '
          
          ' . $this->dateTimeView->show() . '
          </div>

        </body>
      </html>
    ';
  }

  private function swapLoginOrRegisterView() : string {
		if (isset($_GET[self::$registerButton])) {
      return $this->registerView->response();
    }
    else {
      return $this->loginView->response();
    }
  }

}
