<?php
namespace BlueSeed\Scaffold;
/**
 * @author iann
 *
 *
 */
use BlueSeed\SystemAnnotation;

use BlueSeed\View;

use BlueSeed\ActiveRecord;

class Template {
	private $templateObject;
	private $tmpldir;
	private $data = Array();
	private $controllerName;
	function __construct($controllerName) {
		$this->setController($controllerName);
		$this->tmpldir = __DIR__.DIRECTORY_SEPARATOR."/";
	}
	public function setController($controlerName)
	{
		$this->controllerName = $controlerName;
		View::set('bsscaffold_cname', $controlerName);
	}
	function setData(Array $data){
		$this->data	= $data;
	}
	function setTemplateObject(ActiveRecord $objData)
	{
		$this->templateObject = $objData;
	}
	public function form()
	{
		View::set('bsscaffold_data', $this->data[0]);
		$meta = $this->templateObject->getMeta();
		$fields = $meta->fields;
		foreach ($fields as $idx => $field){
			$sa = SystemAnnotation::createasProperty($this->templateObject, $field);
			$fields[$idx] = New \StdClass();
			$fields[$idx]->nome			= $sa->get('@name');
			$fields[$idx]->type			= $sa->get('@type');
			$fields[$idx]->acceptnull	= $sa->get('@acceptnull');
			$fields[$idx]->primarykey	= $sa->get('@primarykey');
		}
		View::set('bsscaffold_columns', $fields);
		View::set('bsscaffold_indexname', $this->templateObject->getIndexName());
		View::set('bsscaffold_objtype', $meta->type);
		View::render('template_form', $this->tmpldir);

	}
	public function index()
	{
		View::set('bsscaffold_data', $this->data);
		$columns = $this->templateObject->getMeta();
		View::set('bsscaffold_columns', $columns->fields);
		View::set('bsscaffold_indexname', $this->templateObject->getIndexName());
		View::render('template_list', $this->tmpldir);
		// gera a pagina principal com a lista, navegacao e acoes

	}

}

?>