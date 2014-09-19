<?php

class LoginModel {

	private $username;
	private $password;

	public function __construct() {

	}

	public function checkLoginInputs() {

		if(empty($_POST['Username']) && empty($_POST['Password'])) {

			return "Användarnamn saknas";

		} elseif (empty($_POST['Username'])) {

			return "Användarnamn saknas";

		} elseif (empty($_POST['Password'])) {

			return "Lösenord saknas";

		} elseif (isset($_POST['Username']) && isset($_POST['Password'])) {
	  
		   		if ($_POST['Username']=='Admin' && $_POST['Password']=='Password') {

		   			return "Inloggningen lyckades";
		   		} 

	   		return "Felaktigt användarnamn och/eller lösenord";
		}
	}

	public function login($username, $password) {

		if ($_POST['Username']=='Admin' && $_POST['Password']=='Password'){

		   	$this->username = $_POST['Username'];
		   	$this->password = $_POST['Password'];

			if ($this->username == $username && $this->password == $password) {

				$_SESSION['LoggedIn'] = true;

				return true;
			}	
		}

		return false;
	} 

	public function logOut() {

		if (isset($_GET['logOut'])) {
	  		unset($_SESSION['LoggedIn']);
		}
//        	echo "<META HTTP-EQUIV='Refresh' Content='0; URL=index.php'>";
        return;
	}

	public function userIsLoggedIn() {

		if (isset($_SESSION['LoggedIn'])) {

			return true;		
		}

		return false;
	}
}



