<?php
/****************************************************************
		Fichier : cToggleService.php
		Auteur : Jeremy Besserer-Lemay
		Fonctionnalité : Controleur du Toggle de services
			Date: 2017-09-30
			
			Dernière modification:
			2017-09-30     Jeremy-Besserer-Lemay   1 Creation
 ******************************************************************/
require_once '../MoteurBD/moteurBD.php';
require_once '../Gestionnaire/gToggleService.php';
$variable = $_GET['id'];

$sql = new moteurBD();
$gToggle = new gToggleService();

$service = $sql->getService($variable);

if(strcmp($service[0]['actif'],'1')== 0){
    $gToggle->deactivateService($variable);
}else{
    $gToggle->activateService($variable);
}

header("Location: ../PageAdmin/service.php");





