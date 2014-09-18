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

	public function doSubmit() {

		if ($this->view->userSubmitted()) {

			return $this->view->checkLoginInputs();

		} else {

			return $this->view->showLoginForm();
			
		}
	}
}
