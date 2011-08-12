<?php
include '../Application/bootstrap.php';
if (isset(ENCODING)){
        header('Content-type: text/html; charset='.ENCODING);
}
$C = new BlueSeed\ApplicationController();
$C->dispatch();

