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
   
    $inArr = trim($_POST['urls'],","); 
	
	$qry  = "SELECT urno ,id, outletname, DAYOFWEEK(posting_date) as week_day,(IF((WEEK(posting_date)%2)=1,1,2)) AS callweek FROM outlets WHERE urno in ($inArr)
		ORDER BY callweek ASC, week_day ASC "; 
	$stmt = $db->con->prepare($qry);  
	//$stmt->bind_param($types, ...$inArr);
	$stmt->execute(); 		
	$stmt->bind_result($urno,$id,$outletname,$week_day,$callweek);
	
	 while($stmt->fetch()){ 
	 ?>
	 <tr id="dlete<?php echo $id ?>"> 
	   <td><?php echo $id ?></td>	 
	  <th scope="row"><?php echo $urno ?></th>
      <td><?php echo $outletname ?></td>
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
      <td><?php echo $callweek ?></td>
	   </tr>
	 <?php
	 }
  	
?>

 