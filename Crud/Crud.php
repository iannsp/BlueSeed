<?php
namespace BlueSeed\Crud;
use BlueSeed\ActiveRecord;
use BlueSeed\Request;
/**
 * @author iann
 *
 *
 */
class Crud implements CrudInterface {
	/**
	 *
	 * the ActiveRecord Data
	 * @var ActiveRecord
	 */
	private $dataObject;

	public function __construct(ActiveRecord $dataObject)
	{
		$this->dataObject 	= $dataObject;
	}
	public function create	(Array $postData)
	{
		$idxname	= $this->dataObject->getIndexName();
		$meta		= $this->dataObject->getMeta();
        foreach ($postData as $k => $datum) {
        	if ($k == $idxname )
        		continue;
        	$this->dataObject->$k	= $datum;
        }
        $this->dataObject->Save();
	}
	public function read	(Array $findData)
	{
		$meta		= $this->dataObject->getMeta();
		$fields = Array();
		foreach ($meta->fields as $field) {
			$fields[ $field ] = $this->dataObject->$field;
		}
		return	$fields;
	}
	public function update	(Array $postData)
	{
		$this->create($postData);
	}
	public function delete	(Array $findData)
	{
		$idxname	= $this->dataObject->getIndexName();
		$meta		= $this->dataObject->getMeta();
		if (array_key_exists($idxname, $findData)) {
			$data = $this->dataObject->find( $findData[$idxname]);
			$data->delete();
		}
	}
}
