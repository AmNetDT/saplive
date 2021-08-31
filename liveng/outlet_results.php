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
   
    $pas = trim($_POST['pass']); 
	$pin = trim($_POST['pin']); 
	
	
	
	$qry  = "select id, employee_id,  call_week, DAYOFWEEK(start_date) as 'week_day' from employee_outlet WHERE  EMPLOYEE_ID = 
		(select employee_id from  users where username = ? and password = ?) and end_date LIKE '0000-00-00 00:00:00'"; 
	$stmt = $db->con->prepare($qry);  
	$stmt->bind_param('ss',$pas,$pin);
	$stmt->execute(); 		
	$stmt->bind_result($id,$employee_id,$call_week,$week_day);
	
	 while($stmt->fetch()){ 
	 ?>
	             <tr class="employee_outlet_id" id="filterid<?php echo $id ?>">
                  <th scope="row"><?php echo $employee_id ?></th>
                  <td><?php echo $call_week ?></td>
				  <td><?php 
	  if($week_day==1){
		 echo "sunday"; 
	  }else if($week_day==2){
		  echo "monday";
	  }else if($week_day==3){
		  echo "tuesday";
	  }else if($week_day==4){
		  echo "wednessday";
	  }else if($week_day==5){
		  echo "thursday";
	  }else if($week_day==6){
		  echo "friday";
	  }else if($week_day==7){
		  echo "saturday";
	  }
	
	  ?></td>
                  <td><input class="form-control form-control-sm" type="text" id="input<?php echo $id ?>"></td>
                  <td>
				    <button type="submit" class="btn-sm btn btn-primary using_click" id="<?php echo $id ?>"  >Map</button>
				    <img src="rot_small.gif" id="loads" width="18" height="18" style="" class="loader<?php echo $id ?>">
				  </td>
                </tr>
	 <?php
	 }
  	
?>

 