<?php
namespace BlueSeed;

/**
 *
 * Administrate the DatabaseConnectionCollection
 * @author ivonascimento <ivo@o8o.com.br>
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 *
 */
class Database {
	/**
	 *
	 * the static instance of Database for the Singleton
	 * @var Database
	 * @access private
	 */
	private static $instance;
	/**
	 *
	 * The DatabaseCollection where any DatabaseConnection are stored
	 * @var DatabaseCollection
	 * @access private
	 */
	private $databaseCollection;
	/**
	 *
	 * the Constructor for Database Instance
	 * @access private
	 * @return void
	 */
	private function __construct() {
		$this->databaseCollection = new DatabaseCollection();
	}
	/**
	 *
	 * The Singloton request method
	 * @return Database
	 * @access public
	 */
	public static function getInstance(){
		if (is_null(self::$instance ) )
			self::$instance = new Database();
		return self::$instance;
	}
	/**
	 *
	 * The method to add DatabaseConnection items in DatabaseCollection
	 * @param String $name the label for request a especific connection
	 * @param DatabaseConnection $dbconn
	 * @access public
	 * @return void
	 */
	public function addDatabase($name, DatabaseConnection $dbconn){
		$this->databaseCollection[ $name ] = $dbconn;
	}
	/**
	 *
	 * use this method to retrieve a DatabaseConnection by your label/name
	 * @param String $name
	 * @throws Exception
	 * @access public
	 * @return DatabaseConnection
	 */
	public function get($name="default"){
		if ($name)
			return $this->databaseCollection[ $name ];
		else if ( count($this->databaseCollection)==1){
			foreach ($this->databaseCollection  as $item)
				return $item;
		}
		else
			throw New \Exception("Necessario indicar um nome de Item");
	}
	/**
	 *
	 * This method are used to load DatabaseConnections
	 * configurations from a ini file in Blue Seed sintax
	 * @param String $confpath
	 * @throws Exception
	 * @access public
	 * @return void
	 */
	public function loadfromConf($confpath){
		$dbitens = parse_ini_file($confpath, true);
		foreach ($dbitens as $idx => $each){
			try{
				$dsn = "{$each['driver']}:host={$each['host']};dbname={$each['database']};port={$each['port']}";
				$this->addDatabase($idx, new DatabaseConnection( new \Pdo( trim($dsn), trim($each['user']), trim($each['password']))) );
			}catch(\Exception $Exception){
				throw new \Exception("Problemas na conexao com o DB {$idx} ({$dsn}) [ {$Exception->getMessage()} ]" );
			}
		}
	}
}

?>