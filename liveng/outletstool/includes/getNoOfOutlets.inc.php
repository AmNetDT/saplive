<?php

if(isset($_GET['id'])){
    $id = $_GET['id'];
}
if(empty($id)){
    echo 'An Error Occurred. Try Again';
}else{
    $id = intval(trim($id));

    if(file_exists('mapoutlet.php')){
        require('mapoutlet.php');
    }

    $map = new MapOutlet();

    echo $getOutlets = $map->getOutlets($id);
}

?>