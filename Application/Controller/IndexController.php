<?php
namespace Application\Controller;
class IndexController extends \BlueSeed\Controller implements \BlueSeed\ControllerInterface{

	public function Index(){
		\BlueSeed\View::render('system_blueseedinstalledok');
	}
	public function teste(){
		var_dump($this->GET);
	}
}
?>