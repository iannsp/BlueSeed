<?php
header('Content-type: application/json');
$status = isset($status)?$status:200;
Service::Header($status);
$jdados = Array("request"=>$maindata, "status"=>$status);
echo json_encode( $jdados );
