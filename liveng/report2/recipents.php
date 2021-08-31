<?php 

function connect($db){
    $servername = "91.109.247.182";
    $username = "mtrader";
    $password = "gtXeAg0dtBB!";
    $conn = new mysqli($servername, $username, $password);
    $conn->select_db($db);
    return $conn;
}

function getRecipients($rec){ 
    $emails = array();
    $qry = "select email from recipients where category like '%|$rec|%'";
    if($result = connect('call_centre')->query($qry)){
        While($row = $result->fetch_row()){
            $emails[]  = $row[0];
        }
    }
    return $emails;//ails;
}

?>