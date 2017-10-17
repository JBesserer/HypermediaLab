<?php 

    require_once '../MoteurBD/moteurBD.php';

    $moteur = new moteurBD();


    $idClient = $_GET['id_Client'];
    
    
    $result=$moteur->getInfoClient($idClient);
    
    echo json_encode($result);
       
?>
