
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
	
	/**
	*	Not used
	*/
	//private $username;
	//private $password;
	
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
		}
		return false;
	}

	public function getCookieName() {

		if (isset($_COOKIE[$this->strUsernameCookie])) {

			return $_COOKIE[$this->strUsernameCookie];
		}

		return NULL;
	}

	// Hämtar lösenord som är sparad i cookien
	public function getCookiePassword() {

		if (isset($_COOKIE[$this->strPasswordCookie])) {

			return $_COOKIE[$this->strPasswordCookie];
		}

		return NULL;
	}

	// Hämtar token 
	public function getCookieToken() {

		if (isset($_COOKIE[$this->strTokenCookie])) {

			return $_COOKIE[$this->strTokenCookie];
		}

		return NULL;
	}

	// Hämtar input från användarnamnsfältet
	public function getUsername() {

		if (empty($_POST['Username'])) {

			return "";

		} 
		return $_POST['Username'];
	}

	// Hämtar input från användarnamnsfältet
	public function getPassword() {

		if (empty($_POST['Password'])) {

			return "";

		} 
		
		return $_POST['Password'];
	}

	public function removeCookies() {

		if(isset($_COOKIE[$this->strUsernameCookie]) && isset($_COOKIE[$this->strPasswordCookie]) && isset($_COOKIE[$this->strPasswordCookie])) {

				setcookie($this->strUsernameCookie, '', time() - 1*24*60*60);
            	setcookie($this->strPasswordCookie, '', time() - 1*24*60*60);
            	setcookie($this->strTokenCookie, '', time() - 1*24*60*60);

        }

        return NULL; 
	}

	public function setCookieToken() {

		$cookieToken = crypt(date("1") . $_SERVER["HTTP_USER_AGENT"] . date("d"));

		return $cookieToken;
	}

	/* Skapar cookies för att hålla användaren inloggad om checkbox markerad
	och tar bort ev gamla cookies */
	public function keepUserLoggedIn() {

		if (!isset($_POST['remember'])) {

			if(isset($_COOKIE[$this->strUsernameCookie]) && isset($_COOKIE[$this->strPasswordCookie])) {

				setcookie($this->strUsernameCookie, '', time() - 1*24*60*60);
            	setcookie($this->strPasswordCookie, '', time() - 1*24*60*60);
            	setcookie($this->strTokenCookie, '', time() - 1*24*60*60);
            }
		}

		$passwordIsEncrypted = crypt($_POST['Password']);
		$cookieToken = $this->setCookieToken();

		setcookie($this->strUsernameCookie, $_POST['Username'], time() + 1*24*60*60);
		setcookie($this->strPasswordCookie, $passwordIsEncrypted, time() + 1*24*60*60);
		setcookie($this->strTokenCookie, $cookieToken, time() + 1*24*60*60);
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
					<p>Håll mig inloggad: <input type='checkbox' name='remember' value='checkbox'></p>
					<p><input type='submit' name='submit' value='Logga in'></p>
				</div>
			</form>
		";

		return $ret;
	}

	// Visar inloggade sidan
	public function showUserLoggedInPage() {

	//	$showDateTime = $this->showDate();
		
	//	$ret = $this->message = "<h2>$this->username är inloggad</h2>";

		$ret = "
			<form name='logout' method='post' accept-charset='utf-8'>
				<p><input type='submit' name='logout' value='Logga ut'></p>
			</form>
		";

	//	$ret .= "<p>$showDateTime</p>";

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
	
	/**
	*	Added View Methods
	*/
	public function setMessage($s){
		$this->message = '<p>' . $s . '</p>';
	}
	
	public function setBody($s){
		$this->body = $s;
	}
	
	public function setLoggedInStatus($b){
		$this->boolLoggedInStatus = $b;
	}
	
	public function setLoggedInUser($s){
		$this->loggedInUser = $s;
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