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

/*		if ($this->model->userIsLoggedIn()) {

			$this->model->userIsLoggedIn();
			$this->view->showUserLoggedInPage();
		} */

		// Utloggningscase
		if ($this->view->userPressedLogout()) {

			$message = $this->model->logout();
			$body = $this->view->showLoginForm();
		}

		// Användaren är inloggad via session
		if ($this->model->userIsLoggedIn()) {

			$user = $this->model->getSessionUsername();
			$status = "<h2>$user är inloggad</h2>";
			$body = $this->view->showUserLoggedInPage();

		} else {

			// Inloggningscase
			$status = "<h2>Ej inloggad</h2>";
			$body = $this->view->showLoginForm();

			if ($this->view->userPressedLogin() == true) {

				if ($this->model->login($this->view->getUsername(), $this->view->getPassword())) {

					if ($this->view->checkBoxMarked()) {

						$user = $this->model->getSessionUsername();
						$status = "<h2>$user är inloggad</h2>";
						$message = "<p>Inloggning lyckades och vi kommer ihåg dig nästa gång</p>";
						$body = $this->view->showUserLoggedInPage();
						$this->view->keepUserLoggedIn();

					} else {

						$user = $this->model->getSessionUsername();
						$status = "<h2>$user är inloggad</h2>";
						$message = "<p>Inloggning lyckades</p>";
						$body = $this->view->showUserLoggedInPage();
					}

				} else {
						
					if ($this->view->getUsername() == "") {

						$message = "Användarnamn saknas";

					} elseif ($this->view->getPassword() == "") {

						$message = "Lösenord saknas";

					} else {

						$message = "Felaktigt användarnamn och/eller lösenord";
					} 

				}

			}
		}

		//Inloggad via håll mig inloggad-checkboxen
		if ($this->view->getCookieName() && $this->view->getCookiePassword()) {

			$token = $this->view->setCookieToken();

			if ($token == $this->view->getCookieToken()) {

				$user = $this->view->getCookieName();
				$status = "<h2>$user är inloggad</h2>";
				$message = "<p>Inloggning lyckades via cookies</p>";
				$body = $this->view->showUserLoggedInPage(); 

			} else {

				$status = "<h2>Ej inloggad</h2>";
				$message = "<p>Felaktig information i cookie</p>";
				$body = $this->view->showLoginForm(); 
				$this->view->removeCookies();
			}			
		}

		return $status . $message . $body . $showDateTime;
	}
}
