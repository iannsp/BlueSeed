<?php
namespace Application\VO;
/**
 * @tableName Pessoa
 * @indexName id
 * @connectionName default
 */
class PessoaVO extends \BlueSeed\ActiveRecord{
	/**
	 * 
	 * the index 
	 * @var integer
	 */
	public $id;
	/**
	 * 
	 * the name of Pessoa
	 * @var varchar(100)
	 */
	public $nome;
}

?>