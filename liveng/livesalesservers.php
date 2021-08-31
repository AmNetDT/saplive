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

<?php competitions(1168,$db->con) ?>

                  
 
 
  <?php 
 
  function competitions($input,$conn){

    
    $id = $input;
   
       $qr  = "CALL load_tm_rep_livesales_pricing_competition(?)"; 
						$stt = $conn->prepare($qr);  
						$stt->bind_param('i',$id);  
					    $stt->execute(); 		
					    $stt->bind_result($comID,$comName,$comAvai,$comPrice,$comUOM);
						
						$stt->fetch();
 ?>
 <tr>
     <td valign="top" style="font-weight:normal"><div style="width:250px"><?php echo $comName." ".$comAvai." ".$comPrice." ".$comUOM ?></div></td>

   </tr>
 <?php 
  
}	
?>			

 