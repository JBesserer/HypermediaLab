<?php
require_once '../MoteurBD/moteurBD.php';
$variable = $_GET['id'];

$sql = new moteurBD();

$service = $sql->getService($variable);

if(strcmp($service[0]['actif'],'1')== 0){
    
}



