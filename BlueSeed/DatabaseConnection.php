<?php
namespace BlueSeed;

/**
 * 
 * The controller to support interpretation of requests
 * @author ivonascimento <ivo@o8o.com.br>
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 * @package system
 *
 */

class DatabaseConnection {
	
	/**
	 * 
	 * the PDO instance are set here
	 * @var PDO
	 */
	private $conn;
	
	/**
	 * 
	 * the constructor of classe where the configuration are setted
	 * @param string $dsn
	 * @param string $user
	 * @param string $password
	 * @return void
	 */
	function __construct($dsn, $user, $password) {
		try{
			$this->conn = New \PDO($dsn, $user, $password);
		}catch( \PDOException $E){
			throw New \Exception("Impossivel conectar ao DSN {$dsn} - Error:".$E->getMessage() );
		}
	}
	/**
	 * 
	 * retrieve the PDO Instance
	 * @return PDO
	 */
	public function get(){
		return $this->conn;
	}
}

?>