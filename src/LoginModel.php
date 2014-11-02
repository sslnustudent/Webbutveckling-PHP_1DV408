<?php

	require_once("UserRepository.php");
	require_once("User.php");

class LoginModel {



	// Kontroll av sessionvariabeln
	public function getSessionUsername() {

		if (isset($_SESSION['username'])) {

			return $_SESSION['username'];
		} 

		return "";
	}

	// Kontroll av inloggningsuppgifter
	public function login($username, $password) {

		$db = new UserRepository();
		$user = $db->getUser($username);


		if ($username == $user->getName() && $password == $user->getPassword()){

			$_SESSION['LoggedIn'] = true;
			$_SESSION['username'] = $username;
			$_SESSION['userAgent'] = $_SERVER["HTTP_USER_AGENT"];

			return true;	
		}

		return false;
	} 

	// Utloggning
	public function logOut() {
		
		try {
			unset($_SESSION['LoggedIn']);
	  		unset($_SESSION['username']);
		}
		
		catch(Exception $e){
			//Just to make sure application does not break in case sessions doesn't exists / are deleted / tamperd with etc.
		}

	  	unset($_SESSION['LoggedIn']);
	  	unset($_SESSION['username']);
	  	session_destroy();
	}

	// Kontrollerar om användaren är inloggad
	public function userIsLoggedIn() {

		if (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']) {

			return true;		
		}

		return false;
	}

	public function getSessionControl() {

		if ($_SESSION['userAgent'] === $_SERVER["HTTP_USER_AGENT"]) {

			return true;
		}

		return false;
	}

}



