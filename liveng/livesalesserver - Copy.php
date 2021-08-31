<?php  
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
   
    if($d==1){
		        
				 $region  = $_POST['r']; 
				 $company = $_POST['c']; 
		        
		         $qry  = "CALL load_livesales_employees_data(?,?)"; 
				 $stmt = $db->con->prepare($qry);  
				 $stmt->bind_param('ii',$company,$region);  
				 $stmt->execute(); 		
				 $stmt->bind_result($id,$fname,$depot,$arrival,$priotise_arival,$depart,$priotise_depart,$plannedOutLet,$visitedOutLet,$percent,
				 $vehicle,$division,$edcode,$phone_no,$sales_volume);
				 
				 $sn = 1;
				 
				 while($stmt->fetch()){ 
				   
				  if(($priotise_arival=="" || $priotise_depart=="" ) || $percent < 100){
			    ?>
				
				 <tr>
				  <td valign="top" height="10" ><div style="width:30px;"><?php echo $sn; ?></div></td>
                  <td valign="top"><div style="width:80px;"><?php echo $vehicle ?></div></td>
                  <td valign="top"><div style="width:90px;"><?php echo $division ?></div></td>
				  <td valign="top"><div style="width:130px;"><?php echo $fname ?></div></td>
				  <td valign="top"><div style="width:130px;"><?php echo $depot ?></div></td>
          
          <td valign="top" style="text-align:center"><div style="width:100px;">
            <?php echo $plannedOutLet ?>
         </div> </td>
          
				  <td valign="top" style="font-size:13px; text-align:center"><div style="width:70px;">
            <?php if($arrival==""){echo '<li class="fa fa-circle text-red" style="margin:0px;padding:0px;"> </li>';}else{echo '<li class="fa fa-circle text-green" style="margin:0px;padding:0px;"> </li>';} ?>
          </div></td>
                
           <td valign="top" style="font-size:13px; text-align:center"><div style="width:70px;">
            <?php if($depart==""){echo '<li class="fa fa-circle text-red" style="margin:0px;padding:0px;"> </li>';}else{echo '<li class="fa fa-circle text-green" style="margin:0px;padding:0px;"> </li>';} ?>
          </div></td>
          
          <td valign="top" style="text-align:center"><div style="width:90px;"><?php echo $visitedOutLet ; ?></div></td>
          <td valign="top"><div style="width:50px;"><?php echo $sales_volume ?></div></td>
          <td  valign="top" width="45" valign="top"><div style="width:50px;">
                <?php
                  if($percent >= 1 && $percent <= 50){
                ?>   
                  <div style="text-align:center;margin:0px;padding:0px;"><?php echo  $percent ; ?>%</div>
                   
                <?php
                  }else if($percent >= 51 && $percent <= 70){
                ?>
                    <div style="text-align:center;margin:0px;padding:0px;"><?php echo  $percent ; ?>%</div>
                   
                <?php 
                  } else if($percent >= 71 && $percent <= 95){
                 ?> 
                    <div style="text-align:center;margin:0px;padding:0px;"><?php echo  $percent ; ?>%</div>
                  
                <?php
                  }else if($percent >= 96 && $percent <= 100){
                  ?>
                     <div style="text-align:center;margin:0px;padding:0px;"><?php echo  $percent ; ?>%</div>
                   
                  <?php
                  }
                ?>  
                  </div></td>
          <td width="45" valign="top"><div style="width:50px;">
                <?php
                  if($percent >= 0 && $percent <= 50){
                ?>   
                    
                    <div class="progress progress-xs progress-striped active">
                    <div class="progress-bar progress-bar-danger" style="width:<?php echo  $percent;?>%"></div>
                    </div>
                <?php
                  }else if($percent >= 51 && $percent <= 70){
                ?>
                    
                    <div class="progress progress-xs progress-striped active">
                    <div class="progress-bar progress-bar-primary" style="width:<?php echo  $percent;?>%"></div>
                    </div>
                <?php 
                  } else if($percent >= 71 && $percent <= 95){
                 ?> 
                    
                    <div class="progress progress-xs progress-striped active">
                    <div class="progress-bar progress-bar-primary" style="width:<?php echo  $percent;?>%"></div>
                    </div>
                <?php
                  }else if($percent >= 96 && $percent <= 100){
                  ?>
                     
                     <div class="progress progress-xs progress-striped active">
                     <div class="progress-bar progress-bar-success" style="width:<?php echo  $percent;?>%"></div>
                     </div>
                  <?php
                  }
                ?>  
                  </div></td>
                </tr>
				
                <?php					
				  }
				  $sn++;
				}
		
	}else if($d==2){
		
		        $region  = $_POST['r']; 
				$company = $_POST['c']; 
				
				$qry  = "CALL load_tm_employee_data(?,?)"; 
				$stmt = $db->con->prepare($qry);  
				$stmt->bind_param('ii',$company,$region);  
				$stmt->execute(); 		
				$stmt->bind_result($id,$tm_name,$depot,$arrival,$priotise_arival,$depart,$priotise_depart,$vehicle,$division,$plannedOutLet,$visitedOutLet,$edcode,$phone_no,$full_name);
				 
				$sn = 1;
				
				while($stmt->fetch()){ 
				  
			    ?>
				
				    <tr>
				  <td valign="top" height="10" ><div style="width:30px;"><?php echo $sn; ?></div></td>
                  <td valign="top"><div style="width:90px;"><?php echo $division; ?></div></td>
				  <td valign="top"><div style="width:130px;"><?php echo $tm_name; ?></div></td>
                  <td valign="top"><div style="width:130px;"><?php echo $full_name; ?></div></td>
				  <td valign="top"><div style="width:130px;"><?php echo $depot; ?></div></td>
          
          <td valign="top" style="text-align:center"><div style="width:100px;">
            <?php echo $plannedOutLet; ?>
         </div> </td>
          
				  <td valign="top" style="font-size:13px; text-align:center"><div style="width:70px;">
            <?php if($arrival==""){echo '<li class="fa fa-circle text-red" style="margin:0px;padding:0px;"> </li>';}else{echo '<li class="fa fa-circle text-green" style="margin:0px;padding:0px;"> </li>';} ?>
          </div></td>
                
           <td valign="top" style="font-size:13px; text-align:center"><div style="width:70px;">
            <?php if($depart==""){echo '<li class="fa fa-circle text-red" style="margin:0px;padding:0px;"> </li>';}else{echo '<li class="fa fa-circle text-green" style="margin:0px;padding:0px;"> </li>';} ?>
          </div></td>
          
          <td valign="top" style="text-align:center"><div style="width:90px;"><?php echo $visitedOutLet ; ?></div></td>

                </tr>
				
				
				
                <?php					 
				  
				  $sn++;
				}
		
	}
 ?>
              
			

 