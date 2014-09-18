<?php

class LoginModel {

	private $username;
	private $password;

	public function __construct() {

	}

	public function login($username, $password) {

		$this->username = $this->username = $_POST['Username'];
		$this->password = $this->password = $_POST['Password'];

		If ($this->username == $username && $this->password == $password) {

			$_SESSION['LoggedIn'] = true;

			return true;
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
}
