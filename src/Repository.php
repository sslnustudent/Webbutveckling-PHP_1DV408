<?php

abstract class Repository {
	protected $dbUsername = "appUser";
	protected $dbPassword = "1br@Lösen=rd?";
	protected $dbConnstring = "mysql:host=127.0.0.1;dbname=lab4database";
	protected $dbConnection;
	protected $dbTable;

	protected function connection(){

		if($this->dbConnection === NULL){
			$this->dbConnection = new \PDO($this->dbConnstring, $this->dbUsername, $this->dbPassword);
		}
		$this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		return $this->dbConnection;
	}

}
