<?php

require_once("LoginModel.php");
require_once("LoginView.php");


class LoginController {

	private $model;
	private $view;  

	public function __construct() {

		$this->model = new LoginModel();
		$this->view = new LoginView($this->model);
	}

	public function doCheckLogin() {

		$status = "";
		$body;
		$message = "";
		$showDateTime = $this->view->showDate();

		// Inloggningscase
		if ($this->view->userLoggingIn()) {

			$status = "<h2>Ej inloggad</h2>";
			$body = $this->view->showLoginForm();
			$message = $this->model->checkLoginInputs();

			if ($this->model->login($this->view->getUsername(), $this->view->getPassword())) {

				if ($this->view->checkBox()) {

					$this->view->keepUserLoggedIn();
					
				}

				$this->view->userLoggedInPage();
			}

			$this->model->userIsLoggedIn(); 
			
		} else {

			return $this->view->showLoginForm();
		}	

		return $status . $message . $body . $showDateTime;
	}
}
