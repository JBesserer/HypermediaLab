<?php
/****************************************************************
		Fichier : catalogue.php
		Auteur : Jeremy Besserer-Lemay
		Fonctionnalité : Gestionnaire du catalogue des produits
			Date: 2017-08-26

			Vérification:

			Historique de modifications:
			2017-08-26      Jeremy Besserer-Lemay   1 Création
 ******************************************************************/
session_start();
error_reporting(0);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <?php
        include ('../PageInject/EnteteClient.php');
	include ('../MoteurBD/moteurBD.php');
        $moteur = new moteurBD();
        $services = $moteur->populateCatalogue();
        $max = sizeof($services);
        ?>
        
        <?php
        for($i = 0; $i < $max;$i++)
        {
        echo "
        <div id='produitCat'>
                <img id='produitImage' src=". $services[$i]['image'].">
                <p id='titreProd'>" . htmlentities(utf8_encode($services[$i]['service_titre']),0,'UTF-8')."</p> <br>
                <p id='descProd'>".htmlentities(utf8_encode($services[$i]['service_description']),0,'UTF-8')."</p><br>
                <pre id='tarif'> Tarif : ".$services[$i]['tarif']."$</pre> <pre id='duree'> Duree: ".$services[$i]['duree']."h </pre><img id='panierImg' src='../images/icones/panier.png'>
        </div> ";
        }
        ?>
    </body>
</html>

