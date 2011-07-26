<?php

abstract class ActiveRecord{
	private $fields = Array();
	private $values = Array();
	private $type;
	private $tableName;
	private $indexName;
	private $connectionName;
	private function loadMeta(){
		if ($this->type)
			return;
		$rInstance = new ReflectionClass($this);
		$ba		   = New SystemAnnotation( $rInstance->getName() );
		$properties = $rInstance->GetProperties(ReflectionProperty::IS_PUBLIC);
		foreach ($properties as $name => $property){
			array_push($this->fields, $property->getName() );
			array_push($this->values, ( is_null( $value = $property->getValue( $this ) ) )?'default':$value );
		}
		$this->type				= 	$rInstance->getName();
		$this->tableName		= 	$ba->get('@tableName');
		$this->indexName		= 	$ba->get('@indexName');
		$this->connectionName	= 	$ba->get('@connectionName');
		
	}
	public function getIndexName(){
		$this->loadMeta();
		return $this->indexName;
	}
	public function getIndexValue(){
		$idxn = $this->indexName;
		return $this->$idxn;
	}
	
	public function getTableName(){
		$this->loadMeta();
		return $this->tableName;
	}
	public function getConnectionName(){
		$this->loadMeta();
		return $this->connectionName;
	}
	private function setIndexValue($value){
		$idxname 		= $this->getIndexName();
		$this->$idxname = $value;
	}
	public static function find($idvalue){
		$vo = get_called_class();		
		$vo = new $vo();
		$vo->setIndexValue($idvalue);
		$result = Search::Select($vo)->Where()->equal($vo->getIndexName())->exec();
		return (count($result)==1)?$result[0]:NULL;
	}
	public static function select(){
//		Search::Select( )
	}
	public function save(){
		$this->loadMeta();
		if (is_null($this->getIndexValue()))
			$this->insert();
		else
			$this->update();
	}
	private function update(){
		$updateTerm = Array();
		foreach ($this->fields as $idx => $value){
			if ($value != $this->getIndexName() )
				array_push ($updateTerm, "{$value}= '{$this->values[$idx]}'");
		}
		$updatestr =  implode(",",$updateTerm);
		$sql = "update {$this->getTableName()} set {$updatestr} where {$this->getIndexName()} = '{$this->getIndexValue()}';";
		echo $sql;
		$ret =  Database::getInstance()->
		get( $this->getConnectionName() )->
		get()->Exec($sql);
		return $ret;
		
	}
	private function insert(){
		$sql = "insert into {$this->getTableName()} (".implode(",",$this->fields).") values(".implode(",'",$this->values)."');";
		echo $sql;
		Database::getInstance()->
		get( $this->getConnectionName() )->
		get()->Exec($sql);
		return Database::getInstance()->
		get( $this->getConnectionName() )->
		get()->lastInsertId("{$this->getTableName()}_{$this->getIndexName()}_seq");
	}
	public function delete(){
		$this->loadMeta();
		$sql = "delete from {$this->getTableName()} where {$this->getIndexName()} = '{$this->getIndexValue()}';";
		Database::getInstance()->
		get( $this->getConnectionName() )->
		get()->Exec($sql);
		$idxname = $this->getIndexName();
		$this->$idxname = null;
	}
}