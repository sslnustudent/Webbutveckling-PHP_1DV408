<?php

class LoginView {

	private $model;
	private $message = "";
	private $status = "";
	private $username;
	private $password;

	public function __construct(LoginModel $model) {
		$this->model = $model;
	}

	public function showDate() {

		setlocale(LC_ALL, 'sve');
		
		$setDateTime = utf8_encode((strftime("%A, den %d %B &aring;r %Y. Klockan &auml;r [%X]")));

		return $setDateTime;
	}


	public function showLoginForm() {

		$name = isset($_POST['Username']) ? $_POST['Username'] : '';
		$showDateTime = $this->showDate();

/*		if ($this->model->doLogin($this->username, $this->password)) {

			$uName = $this->username;

			$ret = $this->message = "<h2>Admin är inloggad</h2>";

			$ret .= "<p><a href='?logOut' title='Logout'>Logga ut</p>";

			return $ret;

		} else { */

		$ret = $this->message = "<h2>Ej inloggad</h2>";

		$ret .= "
			  	<form name='login' method='post' accept-charset='utf-8'>
					<div>
						<p>$this->status</p>
						<p>Login - Skriv in användarnamn och lösenord</p>
						<p><label for='username'>Användarnamn</label>
						<input type='username' name='Username' value='$name'></p>
						<p><label for='password'>Lösenord</label>
						<input type='password' name='Password'></p>
						<p><input type='submit' name='submit' value='Logga in'></p>
						<p>Håll mig inloggad: <input type='checkbox' name='remember' value='checkbox'></p>
					</div>
				</form>
				<p>$showDateTime</p>";

		return $ret;
	//	}
	}

	public function userSubmitted() {

		if (isset($_POST['submit'])) 
			return true;
		return false;
	}

/*	public function userLoggedIn() {
		
		$correct = $this->status = "Inloggningen lyckades";

	    return $this->showLoginForm($correct);

		
	} 

	public function userLoggedOut() {

	  	if (isset($GET["logOut"])) {
	  		unset($_SESSION['LoggedIn']);
        	unset($_SESSION['userName']);
        	session_destroy();
	  	}
	 } */

	public function checkLoginInputs() {

		if(empty($_POST['Username']) && empty($_POST['Password'])) {

			$user = $this->status = "Användarnamn saknas";

			return $this->showLoginForm($user);

		} else if (empty($_POST['Username'])) {

			$nameErr = $this->status = "Användarnamn saknas";

			return $this->showLoginForm($nameErr);

		} else if (empty($_POST['Password'])) {

			$pwrdErr = $this->status = "Lösenord saknas";

			return $this->showLoginForm($pwrdErr);

	    } else if (!$_POST['Username']=='Admin' || !$_POST['Password']=='Password') {

	    	$wrongInput = $this->status = 'Felaktigt användarnamn och/eller lösenord';

	    	return $this->showLoginForm($wrongInput);

	    } else if (isset($_POST['Username']) && isset($_POST['Password'])){
	  
		   		if ($_POST['Username']=='Admin' && $_POST['Password']=='Password'){

		   			$this->username = $_POST['Username'];
		   			$this->password = $_POST['Password'];

		   			if($this->model->login($this->username, $this->password)) {

		    		$correct = $this->status = "Inloggningen lyckades";

		    		return $this->showLoginForm($correct); 
		    		}
		   		} 

	   		$incorrect = $this->status = 'Felaktigt användarnamn och/eller lösenord';

	   		return $this->showLoginForm($incorrect);
		}
	} 
}


