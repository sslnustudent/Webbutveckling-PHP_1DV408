
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
	public function checkBoxMarked() {

		if(isset($_POST['remember'])) {
			
			return true;

		} else {

			return false;
		}
		
	}

	public function getCookieName() {

		if (isset($_COOKIE['username'])) {

			return $_COOKIE['username'];

		} else {

			return NULL;
		}		
	}

	// Hämtar lösenord som är sparad i cookien
	public function getCookiePassword() {

		if (isset($_COOKIE['password'])) {

			return $_COOKIE['password'];

		} else {

			return NULL;
		}		
	}

	// Hämtar token 
	public function getCookieToken() {

		if (isset($_COOKIE['cookietoken'])) {

			return $_COOKIE['cookietoken'];

		} else {

			return NULL;
		}
	}

	// Hämtar input från användarnamnsfältet
	public function getUsername() {

		if (empty($_POST['Username'])) {

			return "";

		} else {

			return $_POST['Username'];
		}		
	}

	// Hämtar input från användarnamnsfältet
	public function getPassword() {

		if (empty($_POST['Password'])) {

			return "";

		} else {

			return $_POST['Password'];
		}		
	}

	public function removeCookies() {

		if(isset($_COOKIE['username']) || isset($_COOKIE['password']) || isset($_COOKIE['cookietoken'])) {

				setcookie('username', '', time() - 1*24*60*60);
            	setcookie('password', '', time() - 1*24*60*60);
            	setcookie('cookietoken', '', time() - 1*24*60*60);

        } else {

        	return NULL;
        }        
	}

	public function setCookieToken() {

		$cookieToken = crypt(date("1") . $_SERVER["HTTP_USER_AGENT"] . date("d"));

		return $cookieToken;
	}

	/* Skapar cookies för att hålla användaren inloggad om checkbox markerad
	och tar bort ev gamla cookies */
	public function keepUserLoggedIn() {

		if (!isset($_POST['remember'])) {

			if(isset($_COOKIE['username']) || isset($_COOKIE['password']))
			{

				setcookie('username', '', time() - 1*24*60*60);
            	setcookie('password', '', time() - 1*24*60*60);
        //    	setcookie('cookietoken', '', time() - 1*24*60*60);
            }
		} 

		$passwordIsEncrypted = crypt($_POST['Password']);
		$cookieToken = $this->setCookieToken();

		setcookie('username', $_POST['Username'], time() + 1*24*60*60);
		setcookie('password', $passwordIsEncrypted, time() + 1*24*60*60);
		setcookie('cookietoken', $cookieToken, time() + 1*24*60*60);
	}

	// Sätter aktuell tid och datum
	public function showDate() {

		setlocale(LC_ALL, 'sve');
		
		$setDateTime = utf8_encode(ucfirst(strftime("%A, den %d %B &aring;r %Y. Klockan &auml;r [%X]")));

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
	public function showUserLoggedInPage() {

		$ret = "
				<form name='logout' method='post' accept-charset='utf-8'>
				<p><input type='submit' name='logout' value='Logga ut'></p>
				</form>";

		return $ret;		
	} 

	// Kontrollerar om användaren tryckt på logga in-knappen
	public function userPressedLogin() {

		if (isset($_POST['submit'])) {

			return true;
		} 			 
		return false;
	}

	// Kontrollerar om användaren tryckt på logga ut-knappen
	public function userPressedLogout() {

		if (isset($_POST['logout'])) {

			return true;
		}
		return false;
	}
}



