<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\UploadedFileInterface;

require 'vendor/autoload.php';

 $config = [
 	'settings' => [
 		'displayErrorDetails' => true
 	]
 ];

$app = new \Slim\App($config);


$app->post('/employeeDetails', function ($request,$response){

	require 'appmodule/employeeDetails.php';
	$interface = new employeeDetails();
	$username = $request->getParam('username');
	$pin = $request->getParam('pin');
	return $interface->implement($username,$pin,$response);

});

$app->post('/createOutlets', function ($request,$response){

	require 'appmodule/createOutlets.php';
	$interface = new createOutlets();
	$empid = $request->getParam('id');
	$no = $request->getParam('no');
	
	return $interface->implement($empid, $no, $response);

});

$app->run();

?>

