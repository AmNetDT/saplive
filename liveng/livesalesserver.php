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
   
   				$date = date('Y-m-d');
				
    			if($delimiter==1){
          
            if($btnRegion==1) {
              $stm = $conn->prepare(DbQuery::repsLiveDataHo());
              $stm->execute(array($date,$date,$date,$date,$date));
            }else{
              if($syscate_id_keys==1){
                $stm = $conn->prepare(DbQuery::repsLiveData());
                $stm->execute(array($date,$date,$date,$date,$date,$btnRegion));
              }else if($syscate_id_keys==3){
                $stm = $conn->prepare(DbQuery::repsLiveData());
                $stm->execute(array($date,$date,$date,$date,$date,$btnRegion));
              }else if($syscate_id_keys==4){
                $stm = $conn->prepare(DbQuery::repsLiveDataSupervisor());
                $stm->execute(array($date,$date,$date,$date,$date,$btnRegion,$depots_id_keys));
              }
            }
           
				 
				 $sn = 1;
				 
				 while($stmp = $stm->fetch()){
          
			    ?>
				
				 <tr>
				  <td valign="top"><div style="width:30px;"><?php echo $sn; ?></div></td>
                  <td valign="top"><div style="width:80px;"><?php echo $stmp['channel'] ?></div></td>
                  <td valign="top"><div style="width:120px;"><?php echo $stmp['fullname'] ?></div></td>
				  <td valign="top"><div style="width:100px;"><?php echo $stmp['depot'] ?></div></td>
				  <td valign="top"  style="text-align:center"><div style="width:70px;">
                  <?php  
				    if($stmp['clockin']==null){
				  ?>
                  
                  <li class="fa fa-circle text-red" style="margin:0px;padding:0px;"> </li>
                  <?php
					}else{
				  ?>
				  <li class="fa fa-circle text-green" style="margin:0px;padding:0px;"> </li>
                  <?php
					} 
				  ?>
                  <div style="font-size:9px; font-weight:bold"><?php echo $stmp['clockin'] ?></div>
                  </div></td>
         		  
                  
                  <td valign="top" style="text-align:center"><div style="width:90px;">
				  <?php  
				    if($stmp['clokout']==null){
				  ?>
                   <li class="fa fa-circle text-red" style="margin:0px;padding:0px;"> </li>
                  <?php
					}else{
				  ?>
				  <li class="fa fa-circle text-green" style="margin:0px;padding:0px;"> </li>
                  <?php
					} 
				  ?>
                  <div style="font-size:9px; font-weight:bold"><?php echo $stmp['clokout'] ?></div>
                  </div> </td>
         		  <td valign="top" style="text-align:center"><div style="width:80px;"><?php echo $stmp['plannedoutlet'] ?></div></td>
          		  <td valign="top" style="font-size:13px; text-align:center">
                   <div style="width:60px;">
				   	<?php echo $stmp['visitoutlet'] ?>
                   </div>
                  </td>
                  <td valign="top"><div style="width:70px;"><?php echo $stmp['token'] ?></div></td>
          
          
                  <td valign="top">
                      <?php 
                      if($stmp['visitoutlet']!=0 || $stmp['plannedoutlet']!=0){
                      ?>
                      <?php
                        $percent = ($stmp['visitoutlet']/$stmp['plannedoutlet'])*100;
                      ?>
                        <div style="text-align:center;margin:0px;padding:0px;"><b><?php echo  round($percent) ; ?>%</b></div>
                        <div style="width:50px;">
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
                        </div>

                      <?php
                      }else{
                      ?>
                      <div style="text-align:center;margin:0px;padding:0px;"><b>0%</b></div>
                        <div style="width:50px;">
                        <div class="progress progress-xs progress-striped active">
                        <div class="progress-bar progress-bar-danger" style="width:0%"></div>
                        </div>
                      <?php
                      }
                      ?>
                      
                  </td>
                  
                  
          <td  valign="top" width="45" ><div style="width:50px;">
                
                  </div></td>
                  
          <td width="45" valign="top"><div style="width:50px;">
               
                  </div></td>
                  
                  <td valign="top"><div style="width:70px;"><div></div></td>
                </tr>
				
                <?php					
				  //}
				  $sn++;
				}
		
	}
	
 ?>
      

 