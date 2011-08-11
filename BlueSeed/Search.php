<?php
namespace BlueSeed;

/**
 * 
 * This class make possible SQL Commands to retrieve data
 * @author ivonascimento <ivo@o8o.com.br>
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 * @package system
 */
Class Search{
	/**
	 * 
	 * stored the sql sentence are created
	 * @var string
	 */
	private $sqlExp = "";
	/**
	 * 
	 * store a instance of VO with the parameter used in search
	 * @var VO
	 */
	private $vo;
	/**
	 * 
	 * Constructor
	 * @param VO $vo this VO have the basic parameters used to perform the search
	 * @param string $fields Optional Parameter where are set the request fields into Result
	 * @access private
	 */
	private function __construct($vo, $fields='*'){
		$this->vo = $vo;
		if ($fields != '*'){
			$fields = explode(',', $fields);
			foreach ($fields as &$field){
				$field = $vo->getTableName().".".trim($field);
			}
			$fields = implode(',', $fields);
		}else
			$fields = $vo->getTableName().'.*';

		$this->sqlExp = "Select {$fields} from {$vo->getTableName()}";
	}

	/**
	 * 
	 * Request a New Class of Search
	 * @param activeRecord $vo a instance of a VO
	 * @param string $fields a list of fields
	 * @access public
	 * @return Search
	 */
	public static function Select(activeRecord $vo, $fields='*'){
		return new Search( $vo, $fields );
	}
	/**
	 * 
	 * Add the expression isNull to Search
	 * @param string $param a field from VO where the value is setted like '%value%'
	 * @return Search
	 * @access public
	 */
	public function isnull($param){
		$this->sqlExp.= " {$this->vo->getTableName()}.{$param} is null ";
		return $this;
	}	
	public function in($param){
		$this->sqlExp.= " {$this->vo->getTableName()}.{$param} in ({$this->vo->$param}) ";
		return $this;
	}
	public function equal($param){
		$this->sqlExp.= " {$this->vo->getTableName()}.{$param} = '{$this->vo->$param}' ";
		return $this;
	}
	public function _($literal){
		$this->sqlExp.= " {$literal} ";
		return $this;
	}
	public function like( $param){
		$this->sqlExp.= " {$this->vo->getTableName()}.{$param} like '{$this->vo->$param}' ";
		return $this;
	}
	public function notlike( $param){
		$this->sqlExp.= " {$this->vo->getTableName()}.{$param} not like '{$this->vo->$param}' ";
		return $this;
	}
	public function ilike( $param){
		$this->sqlExp.= " {$this->vo->getTableName()}.{$param} ilike '{$this->vo->$param}' ";
		return $this;
	}
	/**
	 * 
	 * used to mapping common SQL instruction
	 * @param string $name
	 * @param Array $arg
	 */
	public function __call($name, $arg){
		$this->sqlExp.=" {$name} ";
		return $this;
	}
	/**
	 * 
	 * configure Subquerys
	 * @param string $field a field name used to construct the 'in' SQL instruction
	 * @param Search $search
	 * @return Search
	 * @access public
	 */
	public function inSearch( $field, Search $search){
		$this->sqlExp .= "{$this->vo->getTableName()}.{$field} in (". $search->sqlExp .") ";
		return $this;
	}
	/**
	 * 
	 * perform the Search into DatabaseConnection configured into VO
	 * @throws Exception
	 * @return PDOStatement
	 * @access public
	 */
	public function exec(){
		$dataModel = get_class($this->vo);
		$obj = new $dataModel();
		try{
		$data = Database::getInstance()->
				get( $this->vo->getConnectionName() )->
				get()->query($this->sqlExp);
		$dados = $data->fetchAll( \PDO::FETCH_ASSOC );
		}catch( \Exception $e){
			throw New \Exception ("Erro ao executar a pesquisa");
		}
		$return = Array();
		foreach ($dados as $idxRec => $Rec){
			$obj = new $dataModel();
			foreach ($Rec as $idx => $value){
					$obj->$idx = $value;
				}
				$obj->$idx = $value;
				array_push($return, $obj);
		}
		return $return;
	}
}
?>