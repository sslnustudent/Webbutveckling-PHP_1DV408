
<?php

class LoginView {

	private $model;
	private $username;
	private $password;
	private $message = "";

	public function __construct(LoginModel $model) {
		$this->model = $model;
	}

	// Kontrollerar om håll mig inloggad-checkboxen är markerad
	public function checkBox() {

		if(isset($_POST['remember'])) {
			
			return true;
		}
		return false;
	}

	// Hämtar input från användarnamnsfältet
	public function getUsername() {

		if (!empty($POST['username'])) {

			return $POST['username'];
		}
	}

	// Hämtar input från användarnamnsfältet
	public function getPassword() {

		if (!empty($POST['password'])) {

			return $POST['password'];
		}
	}

	/* Skapar cookies för att hålla användaren inloggad om checkbox markerad
	och tar bort ev gammal cookies */
	public function keepUserLoggedIn() {

		if (!isset($_POST['remember'])) {

			if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {

				setcookie('username', '', time() - 1*24*60*60);
            	setcookie('password', '', time() - 1*24*60*60);
            }
		}

		setcookie('username', $this->username, time() + 1*24*60*60);
		setcookie('password', $this->password, time() + 1*24*60*60);
	}

	// Sätter aktuell tid och datum
	public function showDate() {

		setlocale(LC_ALL, 'sve');
		
		$setDateTime = utf8_encode((strftime("%A, den %d %B &aring;r %Y. Klockan &auml;r [%X]")));

		return $setDateTime;
	}

	// Visar inloggningssidan
	public function showLoginForm() {

		$name = isset($_POST['Username']) ? $_POST['Username'] : '';

		$ret = "
			  	<form name='login' method='post' accept-charset='utf-8'>
					<div>
						<p>Login - Skriv in användarnamn och lösenord</p>
						<p><label for='username'>Användarnamn</label>
						<input type='username' name='Username' value='$name'></p>
						<p><label for='password'>Lösenord</label>
						<input type='password' name='Password'></p>
						<p><input type='submit' name='submit' value='Logga in'></p>
						<p>Håll mig inloggad: <input type='checkbox' name='remember' value='checkbox'></p>
					</div>
				</form>";

		return $ret;
	}

	// Visar inloggade sidan
	public function userLoggedInPage() {

	//	$showDateTime = $this->showDate();
		
		$ret = $this->message = "<h2>$this->username är inloggad</h2>";

		$ret .= "
				<form name='logout' method='get' accept-charset='utf-8'>
				<p><input type='submit' name='logout' value='Logga ut'></p>
				</form>";

	//	$ret .= "<p>$showDateTime</p>";

		return $ret;		
	} 

	// Kontrollerar om användaren tryckt på logga in-knappen
	public function userLoggingIn() {

		if (isset($_POST['submit'])) {

			return true;
		} 			 
		return false;
	}

	// Kontrollerar om användaren tryckt på logga ut-knappen
	public function userLoggingOut() {

		if (isset($_GET['logout'])) {

			return true;
		}
		return false;
	}
}



