<?php
namespace BlueSeed;


/**
 *
 * The controller to support interpretation of requests
 * @author ivonascimento <ivo@o8o.com.br>
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 *
 */

use BlueSeed\Communication\Mailable;

class Email {
    /**
     *
     * the Mailable InstanceMailable
     * @var Mailable
     */
    private $mailmethod;
    /**
     *
     * the Message Body
     * @var string
     */
    private $body;
    /**
     *
     * Mail Subject
     * @var string
     */
    private $subject;
    /**
     *
     * the e-mail of sender
     * @var string
     */
    private $from;
    /**
     *
     * the e-mail to (can by maore then one)
     * @var string
     */
    private $to;
    /**
     *
     * Constructor where the Mail Pear are Instanciate
     * @param Maileble $mailObject
     * @return void
     */
    public function __construct(Mailable $mailObject){
        $this->mailmethod = $mailObject;
    }
    /**
     *
     * setter to Body
     * @param string
     * @return void
     */
    public function setBody($str){
        $this->body = $str;
        return $this;
    }
    /**Mailable
     *
     * setter to Subject
     * @param string $str
     * @return void
     */
    public function setSubject($str){
        $this->subject = $str;
        return $this;
    }
    /**
     *
     * setter to From
     * @param string $mailfrom
     * @return void
     */
    public function setFrom($mailfrom){
        $this->from = $mailfrom;
        return $this;
    }
    /**
     *
     * setter to TO
     * @param string $mailto
     * @return void
     */
    public function setTo($mailto){
        $this->to = $mailto;
        return $this;
    }
    /**
     *
     * Send the email
     * @param boolean $asHTML
     * @return void
     */
    public function send($asHTML = true){
        if ( !($this->body && $this->from && $this->subject && $this->to) )
            throw  New \Exception ("Falha ao enviar e-mail. Os dados não foram informados.");
        $headers = array("From"=>$this->from, "Subject"=>$this->subject );
        if ($asHTML){
            $headers['Content-type'] =  'text/html; charset=iso-UTF-8';
        }
        try{
            $return = $this->mailmethod->send( $this->to, $headers, $this->body);
        }catch ( \Exception $E){
            throw New \Exception("Falha ao enviar e-mail usando Pear/Mail");
        }

    }
    /**
     *
     * reset the data to prepare a New Mail if all data is newer
     * @return void
     */
    public function clearData(){
        $this->body         = "";
        $this->subject         = "";
        $this->from            = "";
        $this->to            = "";
    }

}

?>