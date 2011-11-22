<?php
namespace BlueSeed;
/**
 * @author iann
 *
 *
 */

use BlueSeed\ActiveRecord;
use BlueSeed\Request;
use BlueSeed\Crud\Crud;
class Scaffold {
	private $objData;
	private $request;
	function __construct(ActiveRecord $objData, Request $request)
	{
		$this->objData	= $objData;
		$this->request	= $request;
	}
	public static function creator(ActiveRecord $objData, Request $request)
	{
		return New Scaffold($objData, $request);
	}
	public function create()
	{

		$crud = New Crud($this->objData);
		$crud->create($this->request->getParams());
	}
	public function read()
	{
		$crud = New Crud($this->objData);
		$crud->read();

	}
	public function update()
	{

	}
	public function delete()
	{

	}
	public function make()
	{
		$indexname = $this->objData->getIndexName();

		if (!is_null($this->request->getQuery($indexname))){
			$this->objData = $this->objData->find(
				$this->request->getQuery($indexname)
			);
		if ($this->request->isPost()){
			// bssop BlueSeed(bs) Scaffold (s) Operation (op)
			if(!is_null($this->request->getParam('bssop'))){
				$this->delete();
			}else {
				$this->create();
			}
		}else {
		}
				$this->read();
				$this->update();
				$this->delete();
			}else{
				$this->read();

			}

		var_dump($this);
	}
}

?>