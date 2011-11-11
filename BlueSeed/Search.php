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

	private $countis = false;
	/**
	 * the count constant
	 * @var unknown_type
	 */
	const COUNT	= 0;
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
		if ($fields === Search::COUNT) {
			$fields = " count({$vo->getIndexName()}) ";
			$this->countis = true;
		}
		else if ($fields != '*'){
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
	public function order_by($param, $by = "ASC"){
		$this->sqlExp.= " ORDER BY {$this->vo->getTableName()}.{$param} {$by} ";
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
	public function between($field, $de, $ate) {
		$this->sqlExp .= "{$this->vo->getTableName()}.{$field} BETWEEN '{$de}' and '{$ate}' ";
		return $this;
	}
	public function EqualMoreThen($field) {
		$this->sqlExp.= " {$this->vo->getTableName()}.{$field} >= '{$this->vo->$field}' ";
		return $this;
	}
	public function MoreThen($field) {
		$this->sqlExp.= " {$this->vo->getTableName()}.{$field} > '{$this->vo->$field}' ";
		return $this;
	}
	public function EqualLessThen($field) {
		$this->sqlExp.= " {$this->vo->getTableName()}.{$field} <= '{$this->vo->$field}' ";
		return $this;
	}
	public function LessThen($field) {
		$this->sqlExp.= " {$this->vo->getTableName()}.{$field} < '{$this->vo->$field}' ";
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
	public function notInSearch( $field, Search $search){
		$this->sqlExp .= "{$this->vo->getTableName()}.{$field} not in (". $search->sqlExp .") ";
		return $this;
	}

	public function unionDistinct(Search $search){
		$this->sqlExp .= "union distinct {$search->getSQL()} ";
		return $this;
	}

	public function getSQL()
	{
		return $this->sqlExp;
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
		$con = Database::getInstance()->
				get( $this->vo->getConnectionName() )->
				get();
		$data = $con->query($this->sqlExp);
		$err = $con->ErrorInfo();
		if ($err[0]!='0000') {
			throw New \PDOException($err[2], $err[0]);
		}
		if ( $this->countis)
			$dados = $data->fetchAll( \PDO::FETCH_NUM);
		else
			$dados = $data->fetchAll( \PDO::FETCH_ASSOC );
		}catch( \Exception $e){
			throw New \Exception ("Erro ao executar a pesquisa: {$e->getMessage()}");
		}
		if ($this->countis) {
			return $dados[0][0];
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