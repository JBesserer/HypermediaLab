<?php
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
        include ('../PageInject/EnteteAdmin.php');
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
                <br><br><br><br>
                <p class='promotion'>Promotions :</p><svg height='45' width='45'>
                    <line x1='45' y1='0' x2='0' y2='45' style='stroke:rgb(255,0,0);stroke-width:2' />
                <img id='rabais25' class='borderPromoNonCourante' src='../images/promotions/25.png'></img> </svg> <img id='rabais10' class='borderPromoCourante' src='../images/promotions/10.png'> <img id='rabais10' class='borderPromoNonCourante' src='../images/promotions/10.png'>
                <img class='reseauxSociaux' src='../images/icones/medias sociaux.jpeg'>
        </div> ";
        }
        ?>
    </body>
</html>

