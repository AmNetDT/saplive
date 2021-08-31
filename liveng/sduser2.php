<?php session_start() ;?>
<?php  

class sduser {   
  
  function __construct() {
      require_once './sql/users.php';
      require_once './dbconfig/db.php';
      $db = new db();
      $this->conn = $db->connect();
   }
        
  function process() { 
      if(@$_REQUEST['b_act']=="login") {
          loginClass( $this->conn);
      }
		if(@$_REQUEST['b_act']=="logout") {
	       logout();
	   }
    }
 }


function loginClass($dbcon){

   $unam    = $_POST['unam'];
   $upass   = $_POST['upass'];
   $json    = @array();
   
   if($unam=="" || $upass==""){
	   $Jason['status']   = 400;
	   $Jason['responce'] = "Please enter both user and password";  
	   echo json_encode($Jason); 
   }else{
	  $un = $unam;
     $up = $upass;    
     $stmt = $dbcon->prepare(DbQuery::liveDataLogin());
     $stmt->execute(array($unam,$upass));
     $row = $stmt->fetch();  
     if($row['id']==null && $row['id']=='') {   
        $Jason['status'] = 400;
        $Jason['responce'] = "<div style='margin-bottom:5px;'>Invalid USERNAME and PASSWORD4</b>";
        echo json_encode($Jason); 
      }else{
        $_SESSION['NTY3ODk3NDM0NTY3O876543235Dkw'] = $row['id'];
        $Jason['status']   = 200;
        $Jason['url']    = 'dashboard.php?';  
        echo json_encode($Jason); 
      } 
   }	
}

function logout() {  
     session_destroy();	  
     print "<script>";
	  print "window.location.href='http://82.163.72.135:8092/mtlive/'";
	  print "</script>";
 } 

   $user = new sduser();
   $user->process();
?>