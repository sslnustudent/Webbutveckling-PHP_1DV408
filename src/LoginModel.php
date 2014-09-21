<?php

class LoginModel {

	private $username;
	private $password;

	public function __construct() {

	}

	// Kontroll av sessionvariabeln
	public function getSessionUsername() {

		if (isset($_SESSION['username'])) {

			return $_SESSION['username'];
		} 

		return "";
	}

	// Kontroll av inloggningsuppgifter
	public function login($username, $password) {

		if ($username =='Admin' && $password =='Password'){

				$_SESSION['LoggedIn'] = "success";
				$_SESSION['username'] = $username;

				return true;	
		}

		return false;
	} 

	// Utloggning
	public function logOut() {

	  	unset($_SESSION['LoggedIn']);
	  	unset($_SESSION['username']);

        return "Du har nu loggat ut";
	}

	// Kontrollerar om användaren är inloggad
	public function userIsLoggedIn() {

		if (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']) {

			return true;		
		}

		return false;
	}
}



