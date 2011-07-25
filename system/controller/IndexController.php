<?php
class IndexController extends Controller implements ControllerInterface{

	public function Index(){
		view::render('system_blueseedinstalledok');
	}
	public function notfound(){
		view::render('system_notfound');
	}
}
?>