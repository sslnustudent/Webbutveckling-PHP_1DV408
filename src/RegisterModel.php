<?php

require_once("UserRepository.php");
require_once("User.php");

class Registering{

	public function checkName($username){

		$db = new UserRepository();
		$user = $db->getUser($username);

		if($user == null){
			return true;
		}
		else{
			return false;
		}

	}
	public function addUser($name, $password){
		$db = new UserRepository();
		$user = $db->addUser($name, $password);
	}
}