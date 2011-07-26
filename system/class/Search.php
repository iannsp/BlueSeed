<?php
Class Search{
	private $sqlExp = "";
	private $vo;
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
	public static function Select(activeRecord $vo, $fields='*'){
		return new Search( $vo, $fields );
	}
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
	
	public function __call($name, $arg){
		$this->sqlExp.=" {$name} ";
		return $this;
	}
	public function inSearch( $field, Search $search){
		$this->sqlExp .= "{$this->vo->getTableName()}.{$field} in (". $search->sqlExp .") ";
		return $this;
	}
	public function exec(){
		$dataModel = get_class($this->vo);
		$obj = new $dataModel();
		$data = Database::getInstance()->
				get( $this->vo->getConnectionName() )->
				get()->query($this->sqlExp);
		$dados = $data->fetchAll(PDO::FETCH_ASSOC);
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