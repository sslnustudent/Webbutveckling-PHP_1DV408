<?php

require_once("RegisterModel.php");

class RegisterView{

	private $model;
	private $old;

	public function __construct() {

		$this->model = new Registering();
	}
	function view(){
		$ret ="";
		
		if(!empty($_POST["Username"])){
			if(strlen($_POST["Username"]) < 3){
				$ret .= "<p>användarnamnet har för få tecken. Minst 3 tecken</p>";
				$ret .= $this->registerForm();
				return $ret;
	 		}
		}
		if(!empty($_POST["Username"]) == ""){
			$ret .= "<p>användarnamnet har för få tecken. Minst 3 tecken</p>";
			$ret .= $this->registerForm();
			return $ret;

		}
		if(!empty($_POST["Password"])  || !empty($_POST["Password2"])){
			if(strlen($_POST["Password"]) < 6 || !empty($_POST["Password2"]) < 6){
				$ret .= "<p>Lösenordet har för få tecken. Minst 6 tecken</p>";
				$ret .= $this->registerForm();
				return $ret;
	 		}
		}
		if(!empty($_POST["Password"]) == "" || !empty($_POST["Password2"]) == ""){
			$ret .= "<p>Lösenordet har för få tecken. Minst 6 tecken</p>";
			$ret .= $this->registerForm();
			return $ret;
		}
		if(!empty($_POST["Password"]) && !empty($_POST["Password2"])){
			if($_POST["Password"] != $_POST["Password2"]){
				$ret .= "<p>Lösenorden matchar inte</p>";
				$ret .= $this->registerForm();
				return $ret;
			}
		}
		if(!empty($_POST["Username"])){
			if($this->model->checkName($_POST["Username"]) == false){
				$ret .= "<p>Användaren finns redan</p>";
				$ret .= $this->registerForm();
				return $ret;
			}
			else if(preg_match("/[^a-zA-Z0-9]/s",$_POST["Username"])){
				$ret .= "<p>Ogilltiga tecken</p>";
				$this->old = preg_replace("/[^a-zA-Z0-9]/s", "", $_POST["Username"]);
				$ret .= $this->registerForm();
				return $ret;
			}
		

		else{
			$this->model->addUser($_POST["Username"], $_POST["Password"]);
						$ret = "
						<p>Registreringen lyckades!</p>
		  	<form name='register' method='post' accept-charset='utf-8'>
				<p><input type='submit' name='back' value='Gå tilbaks'></p>
			</form>";
			return $ret;
			}
		}

	}

	public function registerForm(){
			$ret = "
		  	<form name='register' method='post' accept-charset='utf-8'>
				<div>
				<p><input type='submit' name='back' value='Gå tilbaks'></p>
				<p>Registrera - Skriv in användarnamn och lösenord</p>
				<p><label for='username'>Skriv användarnamn</label>
				<input type='username' value='$this->old' name='Username'></p>
				<p><label for='password'>Skriv lösenord</label>
				<input type='password' name='Password'></p>
				<p><label for='password'>Srkiv lösenord igen</label>
				<input type='password' name='Password2'></p>
				<p><input type='submit' name='Register' value='Registrera'></p>
				</div>
			</form>";
			return $ret;
	}

	public function userPressedRegister() {

		if (isset($_POST['Register'])) {

			return true;
		} 			 
		return false;
	}

	public function userPressedBack() {

		if (isset($_POST['back'])) {

			return true;
		} 			 
		return false;
	}

}