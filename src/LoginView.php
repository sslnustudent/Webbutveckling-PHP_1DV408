<?php

class LoginView {

	private $model;
	private $message = "";
	private $status = "";
	private $username;
	private $password;
	private $showDateTime;


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

	public function userLoggedIn() {

		$showDateTime = $this->showDate();
		
		$ret = $this->message = "<h2>$this->username är inloggad</h2>";

		$ret .= "
				<form name='logout' method='get' accept-charset='utf-8'>
				<p><input type='submit' name='logout' value='Logga ut'></p>
				</form>";

		$ret .= "<p>$showDateTime</p>";

	/*	if (isset($_GET['logOut'])) {

			$this->model->logout();
		} */

		return $ret;		
	} 

/*	public function userLoggingOut() {

		if (isset($_GET['logout'])) {

			return true;
		}
		return false;
	} */

	public function userLoggedOut() {

		if ($this->model->logOut()) {

			$loggedOut = $this->status = "Du har nu loggat ut";

			return $this->showLoginForm($loggedOut);
		}
	}


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

		   			$this->model->login($this->username, $this->password);

		   			if($this->userLoggedIn()) {

		    		$correct = $this->status = "Inloggningen lyckades";

		    		return $this->userLoggedIn($correct); 
		    		}
		   		} 

	   		$incorrect = $this->status = 'Felaktigt användarnamn och/eller lösenord';

	   		return $this->showLoginForm($incorrect);
		}
	} 

	public function checkBox() {

		if (isset($_POST['remember'])) 
			return true;
		return false;
	}
}


