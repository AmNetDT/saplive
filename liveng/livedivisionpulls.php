<?php  
ini_set('max_execution_time', 0);
require_once "initServer.php";
require_once "dbmanServer.php";
require_once "mail/Swift_mail/lib/swift_required.php";
?>


<?php 
   $db  = dbmanServer::connect();				
?>


<?php $c = $_POST['c']; ?>

               

               <option value="0" select="selected">Select Division</option>
				<?php 
				
				 $qry = "CALL load_company_division(?)";
				 $stmt = $db->con->prepare($qry);  
				 $stmt->bind_param('i',$c); 
				 $stmt->execute(); 		
				 $stmt->bind_result($id,$name);
				
				 while($stmt->fetch()){ 
				 ?>
				  <option value="<?php echo $id ?>"><?php echo $name ?></option> 
				 <?php	
				 			
				  }
				  
				 ?>
			</table>

              