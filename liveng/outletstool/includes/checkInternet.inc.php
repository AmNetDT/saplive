<?php 

function is_connected()
{
  $connected = @fopen("http://www.google.com:80/","r");
  if($connected)
  {
     return true;
  } else {
   return false;
  }

} 

$stat = is_connected();

if($stat){
    echo "Connected";
}else{
    echo "Not Connected";
}

?>