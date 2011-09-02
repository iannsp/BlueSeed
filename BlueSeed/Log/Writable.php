<?php
/**
 * @author iann
 *
 *
 */
namespace BlueSeed\Log;
use BlueSeed\Log\Message;
interface Writable
{
	public function write(Message $msg);
}
?>