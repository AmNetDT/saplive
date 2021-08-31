<?php 

class util{
	
  public static function resp($response, $status, $statusMgs){

    $json = array(
      "status"=>$status,
      "statusMsg"=>$statusMgs
    );

    return $response
    ->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
    ->withHeader('Content-Type', 'application/json')
    //->withHeader('otp',$otp)
    ->write(json_encode($json));

  }


  public static function removenon($nulls){
    $removes = "";
    if($nulls!=null) $removes = $nulls; 
    return $removes;
  }

}
?>
