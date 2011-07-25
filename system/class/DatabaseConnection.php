<?php

class DatabaseConnection {
	private $conn;
	function __construct($dsn, $user, $password) {
		try{
			$this->conn = New PDO($dsn, $user, $password);
		}catch(PDOException $E){
			throw New Exception("Impossivel conectar ao DSN {$dsn} - Error:".$E->getMessage() );
		}
	}
	public function get(){
		return $this->conn;
	}
}

?>