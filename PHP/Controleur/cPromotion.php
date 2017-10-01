<?php
/****************************************************************
		Fichier : cPromotion.php
		Auteur : Jeremy Besserer-Lemay
		Fonctionnalité : Controleur de la fenetre Promotion
			Date: 2017-10-01
			
			Dernière modification:
			2017-10-01      Jeremy-Besserer-Lemay   1 Creation
 ******************************************************************/
require_once '../Gestionnaire/gPromotion.php';
$gPromo = new gPromotion();

$eventID = isset($_GET['eventid']) ? $_GET['eventid'] : null;

if($eventID == 1){
    $promotionForAll[0] = isset($_POST['idRabaisModalForm']) ? $_POST['idRabaisModalForm'] : null;
    $promotionForAll[1] = isset($_POST['dateStart']) ? $_POST['dateStart'] : null;
    $promotionForAll[2] = isset($_POST['dateEnd']) ? $_POST['dateEnd'] : null;
    $promotionForAll[3] = isset($_POST['codePromo']) ? $_POST['codePromo'] : null;

    $gPromo->addToAllServices($promotionForAll);
    
}elseif($eventID == 2){
    $promoID = isset($_GET['id']) ? $_GET['id'] : null;
    $gPromo->deletePromotion($promoID);
}else{
    
    $sizePost = count($_POST);
    $promoArray =array();

    for($i=0;$i<$sizePost/3;$i++){
        $promoArray[$i][0] =$_POST['idRabaisModal'.$i.''];
        $promoArray[$i][1] =$_POST['promoTitre'.$i.''];
        $promoArray[$i][2] =$_POST['promoPercent'.$i.'']/100;
    }

    $gPromo->updatePromotion($promoArray);    
}


header("Location: ../PageAdmin/promotion.php");





