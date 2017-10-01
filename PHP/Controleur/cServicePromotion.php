<?php
require_once '../Gestionnaire/gServicePromotion.php';
$gServicePromotion = new gServicePromotion();

$supprimerID = isset($_GET['eventid']) ? $_GET['eventid'] : null;
if($supprimerID !== null){
    $pkServicePromotion = isset($_GET['id']) ? $_GET['id'] : null;
    $gServicePromotion->supprimerServicePromotion($pkServicePromotion);
}else{



$infoServicePromotion = [];

$infoServicePromotion[0] = isset($_POST['idPromoServiceModal']) ? $_POST['idPromoServiceModal'] : null;
$infoServicePromotion[1] = isset($_POST['idRabaisModal']) ? $_POST['idRabaisModal'] : null;
$infoServicePromotion[2] = isset($_POST['idServiceModal']) ? $_POST['idServiceModal'] : null;
$infoServicePromotion[3] = isset($_POST['percentSentData']) ? $_POST['percentSentData'] : null;
$infoServicePromotion[4] = isset($_POST['selectPromo']) ? $_POST['selectPromo'] : null;
$infoServicePromotion[5] = isset($_POST['dateStart']) ? $_POST['dateStart'] : null;
$infoServicePromotion[6] = isset($_POST['dateEnd']) ? $_POST['dateEnd'] : null;
$infoServicePromotion[7] = isset($_POST['codePromo']) ? $_POST['codePromo'] : null;

var_dump($infoServicePromotion);

if($infoServicePromotion[0] == null){
    $gServicePromotion->ajouterServicePromotion($infoServicePromotion);
}else{
    $gServicePromotion->modifierServicePromotion($infoServicePromotion);
}
}
header("Location: ../PageAdmin/service.php");
