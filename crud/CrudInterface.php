<?php

/**
 *
 */
use BlueSeed\ActiveRecord;
use BlueSeed\Request;
interface CrudInterface {
	/**
	 *
	 * Construct the object
	 * @param ActiveRecord $dataObject Used to know what Object to persist
	 * @param Request $request Used to know what do(action)
	 */
	public function __construct(ActiveRecord $dataObject, Request $request);
	/**
	 *
	 * Persist the data into persistence place
	 */
	public function create	();
	/**
	 *
	 * Read the DataObject and create the representation model using view
	 */
	public function read	();
	/**
	 *
	 * Update the dataObject into persistence place
	 */
	public function update	();
	/**
	 *
	 * delete the dataObject into persistence place
	 */
	public function delete	();
	/**
	 *
	 * Solve what action you need do based on Request Object
	 * You can Use this to solve or execute the method you know is needed
	 */
	public function make	();
}

?>