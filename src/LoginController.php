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

		//$status = "";
		//$body;
		//$message = "";
		//$showDateTime = $this->view->showDate();

/*		if ($this->model->userIsLoggedIn()) {

			$this->model->userIsLoggedIn();
			$this->view->showUserLoggedInPage();
		} */

		// Utloggningscase
		if ($this->view->userPressedLogout()) {

			//$message = $this->model->logout();
			$this->model->logout();
			$this->view->setMessage(LoginView::MESSAGE_SUCCESS_LOGOUT);
			//$body = $this->view->showLoginForm();
			return $this->loginPage();
		}

		// Användaren är inloggad via session
		if ($this->model->userIsLoggedIn()) {

			//$user = $this->model->getSessionUsername();
			//$status = "<h2>$user är inloggad</h2>";
			$this->view->setLoggedInStatus(true);
			$this->view->setLoggedInUser($this->model->getSessionUsername());
			//$body = $this->view->showUserLoggedInPage();
			return $this->successPage();

		} //else {

			// Inloggningscase
			//$status = "<h2>Ej inloggad</h2>";
			//$this->view->setLoggedInStatus(false);
			//$body = $this->view->showLoginForm();

			if ($this->view->userPressedLogin() == true) {

				if ($this->model->login($this->view->getUsername(), $this->view->getPassword())) {

					if ($this->view->checkBoxMarked()) {

						//$user = $this->model->getSessionUsername();
						//$status = "<h2>$user är inloggad</h2>";
						//$message = "<p>Inloggning lyckades och vi kommer ihåg dig nästa gång</p>";
						$this->view->setMessage(LoginView::MESSAGE_SUCCESS_LOGIN_REMEBER);
						//$body = $this->view->showUserLoggedInPage();
						$this->view->keepUserLoggedIn();

					} else {

						//$user = $this->model->getSessionUsername();
						//$status = "<h2>$user är inloggad</h2>";
						//$message = "<p>Inloggning lyckades</p>";
						$this->view->setMessage(LoginView::MESSAGE_SUCCESS_LOGIN);
						//$body = $this->view->showUserLoggedInPage();
						
					}
					
					$this->view->setLoggedInStatus(true);
					$this->view->setLoggedInUser($this->model->getSessionUsername());
					return $this->successPage();

				} else {
						
					if ($this->view->getUsername() == "") {

						//$message = "Användarnamn saknas";
						$this->view->setMessage(LoginView::MESSAGE_ERROR_USERNAME);

					} elseif ($this->view->getPassword() == "") {

						//$message = "Lösenord saknas";
						$this->view->setMessage(LoginView::MESSAGE_ERROR_PASSWORD);

					} else {

						//$message = "Felaktigt användarnamn och/eller lösenord";
						$this->view->setMessage(LoginView::MESSAGE_ERROR_USERNAME_PASSWORD);
					} 
					
					$this->view->setLoggedInStatus(false);
					return $this->loginPage();
				}

			}
		//}

		//Inloggad via håll mig inloggad-checkboxen
		//if ($this->view->getCookieName() && $this->view->getCookiePassword()) {
		if ($this->view->getCookieName() !== null && $this->view->getCookiePassword() !== null) {

			$token = $this->view->setCookieToken();

			if ($token == $this->view->getCookieToken()) {

				//$user = $this->view->getCookieName();
				//$status = "<h2>$user är inloggad</h2>";
				$this->view->setLoggedInStatus(true);
				$this->view->setLoggedInUser($this->model->getSessionUsername());
				//$message = "<p>Inloggning lyckades via cookies</p>";
				$this->view->setMessage(LoginView::MESSAGE_SUCCESS_COOKIE_LOGIN);
				//$body = $this->view->showUserLoggedInPage(); 
				return $this->successPage();

			} else {

				//$status = "<h2>Ej inloggad</h2>";
				$this->view->setLoggedInStatus(false);
				//$message = "<p>Felaktig information i cookie</p>";
				$this->view->setMessage(LoginView::MESSAGE_ERROR_COOKIE_LOGIN);
				//$body = $this->view->showLoginForm(); 
				$this->view->removeCookies();
				return $this->loginPage();
			}			
		}

		//return $status . $message . $body . $showDateTime;
		
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
