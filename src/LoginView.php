
<?php

class LoginView {
	
	/**
	*	Constants for error and success messages
	*/
	const MESSAGE_ERROR_COOKIE_LOGIN = 'Felaktig information i cookie.';
	const MESSAGE_SUCCESS_COOKIE_LOGIN = 'Inloggning lyckades via cookies.';
	const MESSAGE_ERROR_USERNAME_PASSWORD = 'Felaktigt användarnamn och/eller lösenord.';
	const MESSAGE_ERROR_USERNAME = 'Användarnamn saknas.';
	const MESSAGE_ERROR_PASSWORD = 'Lösenord saknas.';
	const MESSAGE_SUCCESS_LOGIN = 'Inloggning lyckades.';
	const MESSAGE_SUCCESS_LOGIN_REMEBER = 'Inloggning lyckades och vi kommer ihåg dig nästa gång.';
	const MESSAGE_SUCCESS_LOGOUT = 'Du har nu loggat ut.';
	
	private $strUsernameCookie = 'username';
	private $strPasswordCookie = 'password';
	private $strTokenCookie = 'cookietoken';
	private $model;	
	private $message = '';
	private $body = '';
	private $boolLoggedInStatus = false;
	private $loggedInUser;

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

	public function getCookieControl() {

		if ($_COOKIE[$this->strTokenCookie] == $_COOKIE[$this->strPasswordCookie]) {

			return true;
		}

		return false;
	}

	public function getCookieName() {

		if (isset($_COOKIE[$this->strUsernameCookie])) {

			return $_COOKIE[$this->strUsernameCookie];

		} else {

			return NULL;
		}		
	}

	// Hämtar lösenord som är sparad i cookien
	public function getCookiePassword() {

		if (isset($_COOKIE[$this->strPasswordCookie])) {

			return $_COOKIE[$this->strPasswordCookie];

		} else {

			return NULL;
		}		
	}

	// Hämtar token 
	public function getCookieToken() {

		if (isset($_COOKIE[$this->strTokenCookie])) {

			return $_COOKIE[$this->strTokenCookie];

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
		setcookie($this->strUsernameCookie, '', time() - 1*24*60*60);
        setcookie($this->strPasswordCookie, '', time() - 1*24*60*60);
        setcookie($this->strTokenCookie, '', time() - 1*24*60*60);
	}

	public function setCookieToken() {

		$cookieToken = $this->setEncryptPassword();

		return $cookieToken;
	}

	public function setEncryptPassword() {

		$passwordIsEncrypted = md5($this->getPassword() . time());

		return $passwordIsEncrypted;
	}

	/* Skapar cookies för att hålla användaren inloggad om checkbox markerad
	och tar bort ev gamla cookies */
	public function keepUserLoggedIn() {

		if (!isset($_POST['remember'])) {

			if(isset($_COOKIE[$this->strUsernameCookie]) && isset($_COOKIE[$this->strPasswordCookie])) {

				setcookie($this->strUsernameCookie, '', time() - 3600);
	            setcookie($this->strPasswordCookie, '', time() - 3600);
	            setcookie($this->strTokenCookie, '', time() - 3600);
	        }
		}

		setcookie($this->strUsernameCookie, $this->getUsername(), time() + 3600);
		setcookie($this->strPasswordCookie, $this->setEncryptPassword(), time() + 3600);
		setcookie($this->strTokenCookie, $this->setCookieToken(), time() + 3600);
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
					<p><input type='submit' name='newuser' value='Ny användare'></p>
				</div>
				<div>
					<p>Login - Skriv in användarnamn och lösenord</p>
					<p><label for='username'>Användarnamn</label>
					<input type='username' name='Username' value='$name'></p>
					<p><label for='password'>Lösenord</label>
					<input type='password' name='Password'></p>
					<p>Håll mig inloggad: <input type='checkbox' name='remember' value='checkbox'></p>
					<p><input type='submit' name='submit' value='Logga in'></p>
				</div>
			</form>
		";

		return $ret;
	}

	// Visar inloggade sidan
	public function showUserLoggedInPage() {

		$ret = "
			<form name='logout' method='post' accept-charset='utf-8'>
				<p><input type='submit' name='logout' value='Logga ut'></p>
			</form>
		";

		return $ret;		
	} 
	// Kontroll för ny användare
	public function userPressedNewUser() {

		if (isset($_POST['newuser'])) {

			return true;
		} 			 
		return false;
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
	
	/**
	*	Added View Methods
	*/
	public function setMessage($msg){
		$this->message = '<p>' . $msg . '</p>';
	}
	
	public function setBody($body){
		$this->body = $body;
	}
	
	public function setLoggedInStatus($status){
		$this->boolLoggedInStatus = $status;
	}
	
	public function setLoggedInUser($user){
		$this->loggedInUser = $user;
	}
	
	public function renderHTML(){
		return $this->getStatusHtml() . $this->message . $this->body . $this->showDate();
	}
	
	public function getStatusHtml(){
		if($this->boolLoggedInStatus){
			return '<h2>' . $this->loggedInUser . ' är inloggad</h2>';
		}
		return '<h2>Ej inloggad</h2>';
	}
	
	public function getUsernameFromCookie(){
		return isset($_COOKIE[$this->strUsernameCookie]) ? $_COOKIE[$this->strUsernameCookie] : '';
	}
}
