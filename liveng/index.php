<?php session_start() ;?>
<?php
if(isset($_SESSION['NTY3ODk3NDM0NTY3O876543235Dkw'])){
	
	print "<script>";
	print "window.location.href='dashboard.php'";
	print "</script>";
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Mobile Trader Live v1</title>
		<link rel="stylesheet" type="text/css" href="ext/addex.css"/>
		<script src="ext/jquery-1.10.2.min.js"></script>
		<script src="ext/log.js"></script>

      
    </head>
    <body id="appConteiners">
        <div id="body_container">
		  <div id="body_container_login">
		    <div id="left">
            <img src="logs.fw.png" >
            </div>
			<div id="right">
			<form id="formUserAuth">
            
            <div style="height:15px; padding:10px; background:#00A7D0; margin-bottom:15px; color:#FFF;
             -moz-border-radius: 2px;-webkit-border-radius: 2px; border-radius:2px; display:none" 
             class="err_status" id="formtitle"></div>
             
			  <table width="328" border="1" cellpadding="4" cellspacing="4" id="table_id">
  				 <tr>
    				 <td width="117"><div id="formtitle" >User Name:</div></td>
 				     <td width="195"><div id="formtitle_input">
                     <input type="text" name="unam" id="unam" /></div></td>
  				 </tr>
 			     <tr>
   					 <td><div id="formtitle">Password:</div></td>
  				     <td><div id="formtitle_input">
                     <input type="password" name="upass" id="upass"/>
                     <input type="hidden" name="b_act" value="login">
                     </div></td>
 			     </tr>
  				 <tr>
    				 <td>&nbsp;</td>
  				     <td><div id="submitButton"><input type="submit" value="login" id="logB"
                      style="background:#3C8DBC; border:1px solid #367FA9; color:#FFF;
                      -moz-border-radius: 4px;-webkit-border-radius: 4px; border-radius:4px;"
                     ><img src="rot_small.gif" id="loaders" width="18" height="18"></div></td>
  				 </tr>
			</table> 
			</form>
			</div>
		  </div> 
		</div>
		
		 <div id="body_footer">
            <div id="body_footer_copy">
                Mobile Trader Live 3<br>
              Copyright © 2017 Great Brands Nig ltd and its affiliates. All rights reserved.
                </div>
        </div>
    </body>
</html>
