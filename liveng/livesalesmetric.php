<?php 
ini_set('max_execution_time', 0);
  require_once './sql/users.php';
  require_once './dbconfig/db.php';
  $db = new db();
  $conn = $db->connect();
?>

<?php 
	$btnRegion = $_POST['btnRegion'];
	$region_id_keys = $_POST['region_id_keys'];
	$depots_id_keys = $_POST['depots_id_keys'];
	$syscate_id_keys = $_POST['syscate_id_keys'];
	$delimiter = $_POST['delimiter']; 
?>
 
 
 
<?php 			
			
		    $json = array();
			$json['serverdate']   = date('Y-m-d');
			$json['activerep']    = load_active_sales_rep($conn,$btnRegion,$region_id_keys,$depots_id_keys,$syscate_id_keys,
			$delimiter,date('Y-m-d'));
			$json['clockintime']  = load_metrics_clock_in($conn,$btnRegion,$region_id_keys,$depots_id_keys,$syscate_id_keys,
			$delimiter,date('Y-m-d'));
			$json['clockouttime'] = load_metrics_clock_out($conn,$btnRegion,$region_id_keys,$depots_id_keys,$syscate_id_keys,
			$delimiter,date('Y-m-d'));
			$json['planedoutlet']   = 
			round((load_metrics_visited_outlet($conn,$btnRegion,$region_id_keys,$depots_id_keys,$syscate_id_keys,
			$delimiter,date('Y-m-d'))/
			load_metrics_planed_outlet($conn,$btnRegion,$region_id_keys,$depots_id_keys,$syscate_id_keys,
			$delimiter,date('Y-m-d')))*100,1);
			echo json_encode($json); 
		
?>

<?php 
   
      
		
		
		
		
		function load_active_sales_rep($conn,$btnRegion,$region_id_keys,$depots_id_keys,$syscate_id_keys,$delimiter,$date){
			if($delimiter==1){
          
				if($btnRegion==1) {
				  $stm = $conn->prepare(DbQuery::activeRepBySysAdmin());
				  $stm->execute();
				  $result = $stm->fetch();
				}else{
				  if($syscate_id_keys==1){
					$stm = $conn->prepare(DbQuery::activeRepBySysMonitorAndAdmin());
					$stm->execute(array($btnRegion));
					$result = $stm->fetch();
				  }else if($syscate_id_keys==3){
					$stm = $conn->prepare(DbQuery::activeRepBySysMonitorAndAdmin());
					$stm->execute(array($btnRegion));
					$result = $stm->fetch();
				  }else if($syscate_id_keys==4){
					$stm = $conn->prepare(DbQuery::activeRepBySysSupervisor());
					$stm->execute(array($btnRegion,$depots_id_keys));
					$result = $stm->fetch();
				  }
				}
			}
			return $result['id'];
		}
		
		function load_metrics_clock_in($conn,$btnRegion,$region_id_keys,$depots_id_keys,$syscate_id_keys,$delimiter,$date){
			if($delimiter==1){
          
				if($btnRegion==1) {
				  $stm = $conn->prepare(DbQuery::activeRepBySysAdminClockIn());
				  $stm->execute(array($date));
				  $result = $stm->fetch();
				}else{
				  if($syscate_id_keys==1){
					$stm = $conn->prepare(DbQuery::activeRepBySysAdminAndRepClockIn());
					$stm->execute(array($date,$btnRegion));
					$result = $stm->fetch();
				  }else if($syscate_id_keys==3){
					$stm = $conn->prepare(DbQuery::activeRepBySysAdminAndRepClockIn());
					$stm->execute(array($date,$btnRegion));
					$result = $stm->fetch();
				  }else if($syscate_id_keys==4){
					$stm = $conn->prepare(DbQuery::activeRepBySysTMClockIn());
					$stm->execute(array($date,$btnRegion,$depots_id_keys));
					$result = $stm->fetch();
				  }
				}
			}
			return $result['id'];
		}
		
		function load_metrics_clock_out($conn,$btnRegion,$region_id_keys,$depots_id_keys,$syscate_id_keys,$delimiter,$date){
			if($delimiter==1){
          
				if($btnRegion==1) {
				  $stm = $conn->prepare(DbQuery::activeRepBySysAdminClockOut());
				  $stm->execute(array($date));
				  $result = $stm->fetch();
				}else{
				  if($syscate_id_keys==1){
					$stm = $conn->prepare(DbQuery::activeRepBySysAdminAndRepClockOut());
					$stm->execute(array($date,$btnRegion));
					$result = $stm->fetch();
				  }else if($syscate_id_keys==3){
					$stm = $conn->prepare(DbQuery::activeRepBySysAdminAndRepClockOut());
					$stm->execute(array($date,$btnRegion));
					$result = $stm->fetch();
				  }else if($syscate_id_keys==4){
					$stm = $conn->prepare(DbQuery::activeRepBySysTMClockOut());
					$stm->execute(array($date,$btnRegion,$depots_id_keys));
					$result = $stm->fetch();
				  }
				}
			}
			return $result['id'];
		}
		
		function load_metrics_planed_outlet($conn,$btnRegion,$region_id_keys,$depots_id_keys,$syscate_id_keys,$delimiter,$date){
			if($delimiter==1){
          
				if($btnRegion==1) {
				  $stm = $conn->prepare(DbQuery::AdminPlanedOutlets());
				  $stm->execute(array($date));
				  $result = $stm->fetch();
				}else{
				  if($syscate_id_keys==1){
					$stm = $conn->prepare(DbQuery::RepAndAdminPlanedOutlets());
					$stm->execute(array($date,$btnRegion));
					$result = $stm->fetch();
				  }else if($syscate_id_keys==3){
					$stm = $conn->prepare(DbQuery::RepAndAdminPlanedOutlets());
					$stm->execute(array($date,$btnRegion));
					$result = $stm->fetch();
				  }else if($syscate_id_keys==4){
					$stm = $conn->prepare(DbQuery::TmPlanedOutlets());
					$stm->execute(array($date,$btnRegion,$depots_id_keys));
					$result = $stm->fetch();
				  }
				}
			}
			return $result['id'];
		}
		
		function load_metrics_visited_outlet($conn,$btnRegion,$region_id_keys,$depots_id_keys,$syscate_id_keys,$delimiter,$date){
			if($delimiter==1){
          
				if($btnRegion==1) {
				  $stm = $conn->prepare(DbQuery::AdminVisitedOutlets());
				  $stm->execute(array($date));
				  $result = $stm->fetch();
				}else{
				  if($syscate_id_keys==1){
					$stm = $conn->prepare(DbQuery::RepAndAdminVisitedOutlets());
					$stm->execute(array($date,$btnRegion));
					$result = $stm->fetch();
				  }else if($syscate_id_keys==3){
					$stm = $conn->prepare(DbQuery::RepAndAdminVisitedOutlets());
					$stm->execute(array($date,$btnRegion));
					$result = $stm->fetch();
				  }else if($syscate_id_keys==4){
					$stm = $conn->prepare(DbQuery::TmVisitedOutlets());
					$stm->execute(array($date,$btnRegion,$depots_id_keys));
					$result = $stm->fetch();
				  }
				}
			}
			return $result['id'];
	    }

?>

            
 