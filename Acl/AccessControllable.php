<?php
namespace BlueSeed\Acl;
/**
 *
 */
interface AccessControllable {
	public function can($doit);
	public function allow($it);
	public function denny($it);
}

?>