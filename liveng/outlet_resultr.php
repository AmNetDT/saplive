<?php  
ini_set('max_execution_time', 0);
require_once "initServer.php";
require_once "dbmanServer.php";
require_once "mail/Swift_mail/lib/swift_required.php";
?>

 <?php 
   $d = $_POST['delimiter']; 
 ?>
 
 
 <?php 
   $db  = dbmanServer::connect();			
 ?>


 <?php 
   
    $outlet_id = trim($_POST['outlet_id']); 
	$employee_outlet_id = trim($_POST['employee_outlet_id']); 
	$status = 1;
	
	$qry  = "update employee_outlet set outlet_id = ?, status = ? where id = ?"; 
	$stmt = $db->con->prepare($qry);  
	$stmt->bind_param('iii',$outlet_id,$status,$employee_outlet_id); 		

	if($stmt->execute()){
		echo 200;
	}
  	
?>

 