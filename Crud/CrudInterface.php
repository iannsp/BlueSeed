<?php

namespace BlueSeed\Crud;
use BlueSeed\ActiveRecord;
use BlueSeed\Request;
interface CrudInterface {
	/**
	 *
	 * Construct the object
	 * @param ActiveRecord $dataObject Used to know what Object to persist
	 */
	public function __construct(ActiveRecord $dataObject);
	/**
	 *
	 * Persist the data into persistence place
	 * @param Array $postData
	 */
	public function create	(Array $postData);
	/**
	 *
	 * Read the DataObject and create the representation model using view
	 */
	public function read	(Array $findData);
	/**
	 *
	 * Update the dataObject into persistence place
	 */
	public function update	(Array $postData);
	/**
	 *
	 * delete the dataObject into persistence place
	 */
	public function delete	(Array $findData);
}

?>