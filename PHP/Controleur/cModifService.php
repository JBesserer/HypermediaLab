<?php
/****************************************************************
		Fichier : cModifService.php
		Auteur : Jeremy Besserer-Lemay
		Fonctionnalité : Controleur Modif service
			Date: 2017-09-25
			
			Dernière modification:
			2017-09-25      Jeremy-Besserer-Lemay   1 Creation
 ******************************************************************/
require_once '../Gestionnaire/gModifService.php';

$infoService = [];  

if ($_FILES["file"]["error"] > 0)
{
    echo "Error: " . $_FILES["file"]["error"] . "<br>";
}
else
{
/*echo "Upload: " . $_FILES["file"]["name"] . "<br>";
echo "Type: " . $_FILES["file"]["type"] . "<br>";
echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
echo "Stored in: " . $_FILES["file"]["tmp_name"];*/
$image_dir = '../images/services/';

move_uploaded_file($_FILES['file']['tmp_name'], $image_dir. $_FILES['file']['name']);

$image = $image_dir . $_FILES['file']['name'];

$infoService[0] = $image;
}

$infoService[1] = isset($_POST['idService']) ? $_POST['idService'] : null;
$infoService[2] = isset($_POST['nomService']) ? $_POST['nomService'] : null;
$infoService[3] = isset($_POST['descService']) ? $_POST['descService'] : null;
$infoService[4] = isset($_POST['heureService']) ? $_POST['heureService'] : null;
$infoService[5] = isset($_POST['tarifService']) ? $_POST['tarifService'] : null;

if (isset($_POST['actif'])) {
    $infoService[6] = "1";
}
else{
    $infoService[6] = "0";
}

$response;
$gService = new gModifService();

if(isset($infoService[0])){
    $response = $gService->modifierServicePlusImg($infoService);
}else{
    $response = $gService->modifierService($infoService);
}

header("Location: ../PageAdmin/service.php");



