<?php
namespace BlueSeed\Crud;
use BLueSeed\Acl\CrudAcl;

use BlueSeeed\Acl\AccessControllable;

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
	private $ACL;

	public function __construct(ActiveRecord $dataObject)
	{
		$this->dataObject 	= $dataObject;
		$this->ACL			= $acl;
	}
	public function attachAcl(AccessControllable $acl){
		$this->ACL = $acl;
		return $this;
	}
	public function create	(Array $postData)
	{
		if (!is_null($this->ACL) and !$this->ACL->can(CrudAcl::CREATE)){
			return false;
		}
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
		if (!is_null($this->ACL) and !$this->ACL->can(CrudAcl::RETRIEVE)){
			return Array();
		}
		$meta		= $this->dataObject->getMeta();
		$fields = Array();
		foreach ($meta->fields as $field) {
			$fields[ $field ] = $this->dataObject->$field;
		}
		return	$fields;
	}
	public function update	(Array $postData)
	{
		if (!is_null($this->ACL) and !$this->ACL->can(CrudAcl::UPDATE)){
			$this->create($postData);
		}
	}
	public function delete	(Array $findData)
	{
		if (!is_null($this->ACL) and !$this->ACL->can(CrudAcl::DELETE)){
			return false;
		}
		$idxname	= $this->dataObject->getIndexName();
		$meta		= $this->dataObject->getMeta();
		if (array_key_exists($idxname, $findData)) {
			$data = $this->dataObject->find( $findData[$idxname]);
			$data->delete();
		}
	}
}
