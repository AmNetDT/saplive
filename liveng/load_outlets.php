<?php  
ini_set('max_execution_time', 0);
require_once "initServer.php";
require_once "dbmanServer.php";
require_once "mail/Swift_mail/lib/swift_required.php";
?>

 <?php 
   $d = $_POST['Datess']; 
   
 ?>
 
 
 <?php 
   $db  = dbmanServer::connect();			
 ?>


 <?php 

   $qry  = "CALL populate_sales_route_plan(?)"; 
   $stmt = $db->con->prepare($qry);  
   $stmt->bind_param('s',$d);  
   $success = $stmt->execute(); 
   
	if ($success){
     echo "ok";
    }
   
   
 ?>
              
			

 