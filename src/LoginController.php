<?php

require_once("LoginModel.php");
require_once("LoginView.php");
require_once("RegisterView.php");


class LoginController {

	private $model;
	private $view;
	private $newView;

	public function __construct() {

		$this->model = new LoginModel();
		$this->view = new LoginView($this->model);
		$this->newView = new RegisterView();
	}

	public function doCheckLogin() {

		if($this->newView->userPressedRegister())
		{
			return $this->newView->View();
		}


		if($this->newView->userPressedBack())
		{
			return $this->loginPage();
		}

		if($this->view->userPressedNewUser())
		{
			return  $this->newView->View();
		}

		// Utloggningscase
		if ($this->view->userPressedLogout()) {

			$this->view->removeCookies();
			$this->model->logout();
			$this->view->setMessage(LoginView::MESSAGE_SUCCESS_LOGOUT);

			return $this->loginPage();
		}

		// Användaren är inloggad via session
		if ($this->model->userIsLoggedIn()) {

			if ($this->model->getSessionControl() == false) {

				return $this->loginPage();

			} else {

				$this->view->setLoggedInStatus(true);
				$this->view->setLoggedInUser($this->model->getSessionUsername());

				return $this->successPage();
			}

		} 

		if ($this->view->userPressedLogin() == true) {

			if ($this->model->login($this->view->getUsername(), $this->view->getPassword())) {

				if ($this->view->checkBoxMarked()) {

					$this->view->setMessage(LoginView::MESSAGE_SUCCESS_LOGIN_REMEBER);
					$this->view->keepUserLoggedIn();

				} else {

					$this->view->setMessage(LoginView::MESSAGE_SUCCESS_LOGIN);						
				}
					
				$this->view->setLoggedInStatus(true);
				$this->view->setLoggedInUser($this->model->getSessionUsername());
				return $this->successPage();

			} else {
						
				if ($this->view->getUsername() == "") {

					$this->view->setMessage(LoginView::MESSAGE_ERROR_USERNAME);

				} elseif ($this->view->getPassword() == "") {

					$this->view->setMessage(LoginView::MESSAGE_ERROR_PASSWORD);

				} else {

					$this->view->setMessage(LoginView::MESSAGE_ERROR_USERNAME_PASSWORD);
				} 
					
					$this->view->setLoggedInStatus(false);
					return $this->loginPage();
				}

			}

		//Inloggad via håll mig inloggad-checkboxen
		if ($this->view->getCookieName() !== null && $this->view->getCookiePassword() !== null && $this->view->getCookieToken() !== null) {
			
			if ($this->view->getCookieControl()) {

				$this->view->setLoggedInStatus(true);
				$this->view->setLoggedInUser($this->view->getCookieName());
				$this->view->setMessage(LoginView::MESSAGE_SUCCESS_COOKIE_LOGIN);

				return $this->successPage();

			} else {

				$this->view->setLoggedInStatus(false);
				$this->view->setMessage(LoginView::MESSAGE_ERROR_COOKIE_LOGIN);
				$this->view->removeCookies();
				return $this->loginPage();

			}	
		}		
		/**
		*	Fallback to login page just in case something fails
		*/
		return $this->loginPage();
	}
	
	/**
	*	Added Controller Methods
	*/
	
	private function loginPage(){
		$this->view->setBody($this->view->showLoginForm());
		return $this->view->renderHTML();
	}
	
	private function successPage(){
		$this->view->setBody($this->view->showUserLoggedInPage());
		return $this->view->renderHTML();
	}
}
