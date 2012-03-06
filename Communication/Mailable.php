<?php
namespace BlueSeed\Communication;
/**
 *
 */
interface Mailable {
    /**
     * Send a Mail
     * @param string $to
     * @param array $header
     * @param string $body
     * @return boolean
     */
    public function send( $to, array $header, $body);
}

?>