<?php
include '../Application/bootstrap.php';
if (ENCODING){
        header('Content-type: text/html; charset='.ENCODING);
}
$C = new BlueSeed\ApplicationController();
$C->dispatch();

