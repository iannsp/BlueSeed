<?php

abstract class ActiveRecord{
	private $fields = Array();
	private $values = Array();
	private $type; 
	private $sa;
	private function loadMeta(){
		if ( count($this->fields) )
			return;
		$rInstance = new ReflectionClass($this);
		$this->sa		   = New SystemAnnotation( $rInstance->getName() );
		$properties = $rInstance->GetProperties(ReflectionProperty::IS_PUBLIC);
		foreach ($properties as $name => $property){
			array_push($this->fields, ($fname= $property->getName()) );
			array_push($this->values, $this->$fname )  ;
		}
		$this->type				= 	$rInstance->getName();
	}
	public function getIndexName(){
		$this->loadMeta();
		return $this->sa->get('@indexName');
	}
	public function getIndexValue(){
		$this->loadMeta();
		$idxn = $this->getIndexName();
		return $this->$idxn;
	}
	
	public function getTableName(){
		$this->loadMeta();
		return $this->sa->get('@tableName');
	}
	public function getConnectionName(){
		$this->loadMeta();
		return $this->sa->get('@connectionName');
	}
	private function setIndexValue($value){
		$this->loadMeta();
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
	public static function search(){
//		Search::Select( )
	}
	public function save(){
		$this->loadMeta();
		if (is_null($this->getIndexValue())){
			$id = $this->insert();
			$this->setIndexValue($id);
		}
		else
			$this->update();
	}
	private function update(){
		$updateTerm = Array();
		foreach ($this->fields as $idx => $field){
			if ($field != $this->getIndexName() )
				array_push ($updateTerm, "{$field}= :{$field}");
		}
		$updatestr =  implode(",",$updateTerm);
		$stmt = Database::getInstance()->get( $this->getConnectionName() )->get()->prepare(
			"update {$this->getTableName()} set {$updatestr} where {$this->getIndexName()} = '{$this->getIndexValue()}';"
		);
		foreach ($this->fields as $idx => $field){
			if ($field != $this->getIndexName() )
			$stmt->bindParam(":{$field}", $this->values[$idx]);
		}
		$stmt->execute();
	}
	private function insert(){
		$stmt = Database::getInstance()->get( $this->getConnectionName() )->get()->prepare(
			"insert into {$this->getTableName()} (".implode(",",$this->fields).") values(:".implode(",:",$this->fields).");"
		);
		foreach ($this->fields as $idx => $field){
			$stmt->bindParam(":{$field}", $this->values[$idx]);
		}
		$stmt->execute();
		return Database::getInstance()->
						get( $this->getConnectionName() )->
						get()->
						lastInsertId("{$this->getTableName()}_{$this->getIndexName()}_seq");
	}
	public function delete(){
		$this->loadMeta();
		$stmt = Database::getInstance()->get( $this->getConnectionName() )->get()->prepare(
			"delete from {$this->getTableName()} where {$this->getIndexName()} = :{$this->getIndexName()};"
		);
		$value = $this->getIndexValue();
		$stmt->bindParam(":{$this->getIndexName()}", $value );
		$stmt->execute();
		$this->setIndexValue(null);
	}
}