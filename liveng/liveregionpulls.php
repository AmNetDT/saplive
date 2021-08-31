<?php  
ini_set('max_execution_time', 0);
require_once "initServer.php";
require_once "dbmanServer.php";
require_once "mail/Swift_mail/lib/swift_required.php";
?>


<?php 
   $db  = dbmanServer::connect();				
?>


<?php $b = $_POST['b']; ?>
<?php $c = $_POST['c']; ?>

               <option value="0" select="selected">Select Region</option>
				<?php 
				
				 $qry = "CALL load_company_regions(?,?)";
				 $stmt = $db->con->prepare($qry);  
				 $stmt->bind_param('ii',$b,$c); 
				 $stmt->execute(); 		
				 $stmt->bind_result($id,$regionName);
				
				 while($stmt->fetch()){ 
				 ?>
				  <?php 
				     if($id==1){
					?>
					  <option value="<?php echo $id ?>">PAN Nigeria</option>
					<?php					
					 }else{
					 ?>
					 <option value="<?php echo $id ?>"><?php echo $regionName ?></option>
					<?php
					 }
				  ?>
				   
				<?php				
				  }
				?>
			</table>

              