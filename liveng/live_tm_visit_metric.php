<?php 
ini_set('max_execution_time', 0); 
require_once "initServer.php";
require_once "dbmanServer.php";
require_once "mail/Swift_mail/lib/swift_required.php";
?>

<?php 
   //$d = $_POST['delimiter']; 
?>
 
 
<?php 
   $db  = dbmanServer::connect();			
?>
 
 
 
<?php 
	
		   
		    $region    = $_POST['r']; 
            $company   = $_POST['c']; 
		    $json = array();
			$json['serverdate']        = date('Y-m-d');
			$json['activerep_tm_call'] = load_active_tm_rep($company,$region,$db);
			$json['clockintime']       = load_metrics_clock_in($company,$region,$db);
			$json['clockouttime']      = load_metrics_clock_out($company,$region,$db);
			$json['total_tm_visited_outlet'] = load_metrics_total_tm_visited_outlet($company,$region,$db);
			echo json_encode($json); 
		
?>

<?php 

		function load_metrics_total_tm_visited_outlet($company,$region,$db){
		  
		    $qry  = "CALL load_tm_metrics_visited_outlet(?,?)";
			$stmt = $db->con->prepare($qry);
			$stmt->bind_param('ii',$company,$region);  
			$stmt->execute(); 		
			$stmt->bind_result($out);
			
			if($stmt->fetch()) {
			  $callback =  number_format($out);
			}
			return $callback;
	    }

		function load_metrics_clock_out($company,$region,$db){
		  
		    $qry  = "CALL load_tm_metrics_clock_out(?,?)";
			$stmt = $db->con->prepare($qry);
			$stmt->bind_param('ii',$company,$region);  
			$stmt->execute(); 		
			$stmt->bind_result($out);
			
			if($stmt->fetch()) {
			  $callback =  number_format($out);
			}
			return $callback;
	    }
		
        function load_active_tm_rep($company,$region,$db){
		  
		    $qry  = "CALL load_active_tms(?,?)";
			$stmt = $db->con->prepare($qry);
			$stmt->bind_param('ii',$company,$region);  
			$stmt->execute(); 		
			$stmt->bind_result($out);
			
			if($stmt->fetch()) {
			  $callback =  number_format($out);
			}
			return $callback;
	    }
		
		 function load_metrics_clock_in($company,$region,$db){
		  
		    $qry  = "CALL load_tm_metrics_clock_in(?,?)";
			$stmt = $db->con->prepare($qry);
			$stmt->bind_param('ii',$company,$region);  
			$stmt->execute(); 		
			$stmt->bind_result($in);
			
			if($stmt->fetch()) {
			  $callback =  number_format($in);
			}
			return $callback;
	    }

?>
            
 