<?php

class User{

	private $userId;
	private $userName;
	private $password;

	public function __construct($id, $name, $passwordtmp){
		$this->userId = $id;
		$this->userName = $name;
		$this->password = $passwordtmp;
	}

	public function getId(){
		return $this->userId;
	}

	public function getName(){
		return $this->userName;
	}

	public function getPassword(){
		return $this->password;
	}
}