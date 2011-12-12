<?php

namespace BlueSeed\Acl;
/**
 * @author iann
 *
 *
 */
class CrudAcl implements AccessControllable {
	const BROWSE 		= 'browse';
	const CREATE 		= 'create';
	const RETRIEVE		= 'retrieve';
	const UPDATE		= 'update';
	const DELETE		= 'delete';
	private $browser	= true;
	private $create		= true;
	private $retrieve	= true;
	private $update		= true;
	private $delete		= true;

	function __construct() {

		//TODO - Insert your code here
	}

	/**
	 *
	 * @see AccessControllable::denny()
	 */
	public function denny($it) {
		$this->$it 	= false;
	}
	public function set($name, $value)
	{
		if ($value == 0)
			$this->denny($name);
		else
			$this->allow($name);
	}
	/**
	 *
	 * @see AccessControllable::allow()
	 */
	public function allow($it) {
		$this->$it	= true;
	}

	/**
	 *
	 * @see AccessControllable::can()
	 */
	public function can($doit) {
		return (bool) $this->$doit;
		//TODO - Insert your code here
	}
}

?>