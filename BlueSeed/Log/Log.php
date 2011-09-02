<?php
/**
 * @author iann
 *
 *
 */

namespace BlueSeed\Log;
use BlueSeed\Log\Writable as logWriter;
use BlueSeed\Log\Message;
class Log
{
	/**
	 *the way the messages will be write
	 *@var boolean $async
	 */
	private $async = true;
	/**
	 * the writers where will write the message
	 * @var Array $writers
	 */
	private $writers 	= Array();

	/**
	 * all messages will be write in writers
	 * @var Array $messages
	 */
	private $messages	= Array();
    function __construct ($async = true)
    {
		$this->async = $async;
    }
	/**
	 * add More Writers to Log to make message persist in other
	 * type of datasource
	 * @param logWriter $writer
	 */
    public function addWriter(logWriter $writer)
    {
    	array_push($this->writers, $writer);
    }
    /**
     * Add a message to messages will be writen
     * @param Message $msg
     */
    public function write(Message $msg)
    {
		array_push($this->messages, $msg);
		if(!$this->async) {
			$this->flush();
		}
		return $this;
    }
    /**
     * Make the write action in writers
     */
    public function flush()
    {
		foreach ($this->writers as $w) {
			foreach ($this->messages as $msg) {
				$w->write($msg);
			}
		}
    	$this->messages	= Array();
    }
}
?>