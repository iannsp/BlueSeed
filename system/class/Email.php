<?php

class Email {
	private $mailmethod;
	private $body;
	private $subject;
	private $from;
	private $to;
	public function __construct(){
		$this->mailmethod = Mail::factory("mail");
	}
	public function setBody($str){
		$this->body = $str;
		return $this;
	}
	public function setSubject($str){
		$this->subject = $str;
		return $this;
	}
	public function setFrom($mailfrom){
		$this->from = $mailfrom;
		return $this;
	}
	public function setTo($mailto){
		$this->to = $mailto;
		return $this;
	}
	public function send($asHTML = true){
		$headers = array("From"=>$this->from, "Subject"=>$this->subject );
		if ($asHTML){
			$headers['Content-type'] =  'text/html; charset=iso-UTF-8';
		}
		$this->mailmethod->send( $this->to, $headers, $this->body);
			
	}
	public function clearData(){
		$this->body 		= "";
		$this->subject 		= "";
		$this->from			= "";
		$this->to			= "";
	}
	
}

?>