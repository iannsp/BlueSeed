<?php
namespace BlueSeed\Crud;
/**
 * @author iann
 *
 *
 */
class Crud implements CrudInterface {
	private $dataObject;
	private $request;
	public function __construct(ActiveRecord $dataObject,Request $request)
	{
		$this->dataObject 	= $dataObject;
		$this->request		= $request;
	}
	public function create	()
	{

	}
	public function read	()
	{

	}
	public function update	()
	{

	}
	public function delete	()
	{

	}
	public function make()
	{

	}
}

?>