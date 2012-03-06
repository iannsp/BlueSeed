<?php
namespace BlueSeed;
/**
 *
 * The Active Record make possible persist data from VO's
 * @author ivonascimento <ivo@o8o.com.br>
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 *
 */

abstract class ActiveRecord{
    /**
     * the reflection of VO instance save fields name here
     * @var Array $fields
     * @access private
    */
    private $fields = Array();
    /**
     *
     * reflection of VO instance save the fields values here
     * @var Array $values
     * @access private
     */
    private $values = Array();
    /**
     *
     * the VO Name retrieved using reflectoion
     * @var string $type
     * @access private
     */
    private $type;
    /**
     *
     * the instance of System Annotation Used to return meta data from instance
     * @var SystemAnnotation $sa
     * @access private
     */
    private $sa;

    public function getMeta()
    {
        $meta                   = New \StdClass();
        $meta->fields           = $this->fields;
        $meta->type             = $this->type;
        $meta->systemAnnotation = $this->sa;
        return $meta;
    }
    /**
     *
     * This function load the Metadata from instance
     * @return void
     * @access private
     *
     */
    private function loadMeta(){
        $this->fields   = Array();
        $this->values   = Array();
        $rInstance      = new \ReflectionClass($this);
        $this->type     = $rInstance->getName();
        $this->sa       = \BlueSeed\SystemAnnotation::createasClass( $rInstance->getName() );
        $properties     = $rInstance->GetProperties( \ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $name => $property){
            array_push($this->fields, ($fname= $property->getName()) );
            array_push($this->values, $this->$fname )  ;
        }
    }
    /**
     *
     * This function return the name of Index by Table referenced by VO
     * @return string
     * @access public
     */
    public function getIndexName(){
        $this->loadMeta();
        return $this->sa->get('@indexName');
    }
    /**
     *
     * this function return the value of Index
     * @return mixed
     * @access public
     */
    public function getIndexValue(){
        $this->loadMeta();
        $idxn = $this->getIndexName();
        return $this->$idxn;
    }
    /**
     *
     * return the table name the VO represent
     * @return $string
     * @access public
     */
    public function getTableName(){
        $this->loadMeta();
        return $this->sa->get('@tableName');
    }
    /**
     *
     * return the Connection Name to use when persist data from VO
     * @return string
     * @access public
     */
    public function getConnectionName(){
        $this->loadMeta();
        return $this->sa->get('@connectionName');
    }
    /**
     *
     * set a value to index field
     * @access private
     * @param mixed $value
     * @return void
     */
    private function setIndexValue($value){
        $this->loadMeta();
        $idxname         = $this->getIndexName();
        $this->$idxname = $value;
    }
    /**
     *
     * Fetches all records in a table
     * @access public
     */
    public static function fetchAll(){
        $vo = get_called_class();
        $vo = new $vo();
        $result = Search::Select($vo)->exec();
        return $result;
    }
    /**
     *
     * Find a record and return a instance of VO object used to start
     * the find by index
     * @access public
     * @param mixed $idvalue
     * @param ValueObject
     */
    public static function find($idvalue){
        $vo = get_called_class();
        $vo = new $vo();
        $vo->setIndexValue($idvalue);
        $result = Search::Select($vo)->Where()->equal($vo->getIndexName())->exec();
        return (count($result)==1)?$result[0]:null;
    }
    /**
     *
     * Persist the data from VO into your Table representation
     * The save verify if exist index value and update without, do a insert
     * if insert, the VO index updated to index from insert
     * @access public
     * @return void
     */
    public function save(){
        $this->loadMeta();
        if (is_null($this->getIndexValue())){
            $id = $this->insert();
            $this->setIndexValue($id);
        }
        else
            $this->update();
    }
    /**
     *
     * Update a record represented by VO using the index value
     * @return void
     * @access private
     */
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
    /**
     *
     * Insert a record into table linked to VO
     * @access private
     * @return void
     */
    private function insert(){
        $stmt = Database::getInstance()->get( $this->getConnectionName() )->get()->prepare(
            "insert into {$this->getTableName()} (".implode(",",$this->fields).") values(:".implode(",:",$this->fields).");"
        );
        foreach ($this->fields as $idx => $field){
            $stmt->bindParam(":{$field}", $this->values[$idx]);
        }
        $this->execute($stmt);
        return Database::getInstance()->
                         get( $this->getConnectionName() )->
                         get()->
                         lastInsertId("{$this->getTableName()}_{$this->getIndexName()}_seq");
    }
    /**
     *
     * delete a record using the index
     * @access public
     * @return void
     */
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
    /**
     *
     * @return bool
     * @param \PDO $stmt
     * @access private
     */
    private function execute(&$stmt)
    {
        $stmt->execute();
        $err = $stmt->ErrorInfo();
        if ($err[0]!='0000') {
            throw New \PDOException($err[2], $err[0]);
        }
    }
}