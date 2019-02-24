<?php
include(PWD_TEMPLATES . '/incs/head_api.php');

if (!isset($myObj))
	$myObj = new stdClass();
$myObj->success = false;
$myObj->message = $message;

echo json_encode($myObj);

