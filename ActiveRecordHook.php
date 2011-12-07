<?php
namespace BlueSeed;
/**
 * @author iann
 *
 *
 */

class ActiveRecordHook {
	const BEFORESAVE	= 1;
	const AFTERSAVE 	= 2;
	const BEFOREINSERT	= 3;
	const AFTERINSERT 	= 4;
	const BEFOREUPDATE	= 5;
	const AFTERUPDATE 	= 6;
	const BEFOREDELETE	= 7;
	const AFTERDELETE 	= 8;

	private $hook = Array();
	public function __construct()
	{
		$this->hook [1] = Array ();
		$this->hook [2] = Array ();
		$this->hook [3] = Array ();
		$this->hook [4] = Array ();
		$this->hook [5] = Array ();
		$this->hook [6] = Array ();
		$this->hook [7] = Array ();
		$this->hook [8] = Array ();
	}
	public function add($type, \Closure $callback)
	{
		if(array_key_exists($type, $this->hook)) {
			array_push($this->hook[$type], $callback);
		} else {
			throw New \Exception('Invalid Event Type');
		}
	}
	public function exec($type, ActiveRecord $record)
	{
		if(array_key_exists($type, $this->hook)) {
			foreach ($this->hook[$type] as $hook) {
				$hook($record);
			}
		} else {
			throw New \Exception('Invalid Event Type');
		}
	}
	public function get($type)
	{
		if(array_key_exists($type, $this->hook)) {
			return $this->hook[$type];
		} else {
			throw New \Exception('Invalid Event Type');
		}
	}
	public function count()
	{
		$count = 0;
		foreach( $this->hook as $hooks){
			$count+= count($hooks);
		}
		return $count;
	}
}

?>