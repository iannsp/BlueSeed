<?php

class Database {
	private static $instance;
	private $databaseCollection;
	private function __construct() {
		$this->databaseCollection = new DatabaseCollection();
	}
	public static function getInstance(){
		if (is_null(self::$instance ) )
			self::$instance = new Database();
		return self::$instance;		
	}
	public function addDatabase($name, DatabaseConnection $dbconn){
		$this->databaseCollection[ $name ] = $dbconn;
	}
	public function get($name=null){
		if ($name)
			return $this->databaseCollection[ $name ];
		else if ( count($this->databaseCollection)==1){
			foreach ($this->databaseCollection  as $item)
				return $item;
		}
		else 
			throw New Exception("Necessario indicar um nome de Item");
	}	
	public function loadfromConf($confpath){
		$dbitens = parse_ini_file($confpath, true);
		foreach ($dbitens as $idx => $each){
			try{
				$dsn = "{$each['driver']}:host={$each['host']};dbname={$each['database']};port={$each['port']}";
				$this->addDatabase($idx, new DatabaseConnection( $dsn, $each['user'], $each['password']) );
			}catch(Exception $Exception){
				throw new Exception("Problemas na conexao com o DB {$idx} ({$dsn}) [ {$Exception->getMessage()} ]" );
			}			
		}
				
	}
}

?>