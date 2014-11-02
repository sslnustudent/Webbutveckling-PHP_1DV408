<?php

require_once("Repository.php");
require_once("User.php");

class UserRepository extends Repository{

	private $user;

	public function __construct(){
		$this->dbTable = "user";
	}

	public function addUser($name, $password){

		$db = $this->connection($name, $password);

		$sql = "INSERT INTO $this->dbTable (UserName, Password) VALUES (?, ?)";
		$params = array($name, $password);

		$query = $db->prepare($sql);
		$query->execute($params);
	}

	public function GetUser($name){
		$db = $this->connection();
		$user = null;
		$sql = "SELECT * FROM $this->dbTable WHERE UserName = ?";
		$query = $db->prepare($sql);
		$params = array($name);

		$query->execute($params);

		foreach ($query->fetchAll() as $owner) {
			$id = $owner["UserID"];
			$name = $owner["UserName"];
			$password = $owner["Password"];

			$user = new User($id, $name, $password);
		}
		return $user;
		
	}
}