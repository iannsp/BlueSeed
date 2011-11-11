<?php
namespace BlueSeed;

/**
 *
 * The controller to support interpretation of requests
 * @author ivonascimento <ivo@o8o.com.br>
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
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
	 * @param \PDO $objconn
	 * @return void
	 */
	function __construct( \PDO $objconn) {
			$this->conn = $objconn;
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