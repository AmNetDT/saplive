<?php

if(isset($_GET['id'])){
    $id = $_GET['id'];
}
if(isset($_GET['no'])){
    $no = $_GET['no'];
}
if(empty($id) || empty($no)){
    echo 'An Error Occurred. Try Again';
}else{
    $id = intval(trim($id));
    $no = intval(trim($no));

    if(file_exists('mapoutlet.php')){
        require('mapoutlet.php');
    }

    $map = new MapOutlet();

    $create = $map->createOutlets($id, $no);
    
    echo $create;
}



?>