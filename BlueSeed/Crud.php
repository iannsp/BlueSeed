<?php
namespace BlueSeed;

/**
 * 
 * Construct Crud's with ActiveRecord Mappers
 * @author ivonascimento <ivo@o8o.com.br>
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 * @package system
 * @abstract
 *
 */
abstract class Crud {
	/**
	 * 
	 * the Vo for create the crud
	 * @var ActiveRecord
	 */
	protected $vo;
	private $validators 	= 	Array();
	private $renders		= 	Array(
								'form'		=>	'system_crud_form',
								'list'		=>	'system_crud_list',
								'search'	=>	'system_crud_search',
								'boolean'	=> 	'field_boolean',
								'float'		=> 	'field_float',
								'integer'	=> 	'field_inteer',
								'text'	=> 	'field_text'
								);
	/**
	 * 
	 * Set the Active record used as model to construct the Crud
	 * @param ActiveRecord $vo
	 */
	public function __construct(ActiveRecord $vo) {
		$this->vo = $vo;		
	}
	/**
	 * 
	 * Register Validators to Value Inserted or updated using Form render
	 * @param Validator $validator
	 * @param String $fieldName
	 * @return void
	 * @access public
	 */
	public function registerValidator(Validator $validator, $fieldName=NULL){
		if ($fieldName)
			$this->validators[ $fiedName ] = $validator;
		else
			array_push($this->validators, $validator);
	}
	/**
	 * 
	 * Provide diferente renders to crud parts
	 * @param String $to
	 * @param String $rendername
	 * @access public
	 * @return void
	 * 
	 */
	public function registerRender($to, $rendername){
		if (key_exists($to, $this->renders) && View::renderExists($rendername))
			$this->renders [ $to ]	= $rendername;
	}
	/**
	 * 
	 * Render the crud
	 * @param String $to You Can Render part of Crud or All (if $to is null)
	 * @access public
	 * @return void
	 */
	public function render($to=null){
		if (is_null ( $to ) ){
			foreach ( $this->renders as $render ){
				view::render( $render );
			}
		}
		else
			view::render( $to );
	}
}

?>