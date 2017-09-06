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
        include ('../PageInject/EnteteClient.php');
        include ('../MoteurBD/moteurBD.php');
        $moteur = new moteurBD();
        $services = $moteur->populateCatalogue();
        $max = sizeof($services);
        ?>
        
        
        <div id='produitCat'>
            <img id='produitImage' src="<?php echo $services[0]['image'] ?>">
            <p id='titreProd'> <?php echo $services[0]['service_titre'];?></p> <br>
            <p id='descProd'> <?php echo $services[0]['service_description'];?></p><br>
            <pre id='tarif'> Tarif : <?php echo $services[0]['tarif'];?>$</pre> <pre id='duree'> Duree: <?php echo $services[0]['duree'];?>h </pre><img id='panierImg' src='../images/icones/panier.png'>
        </div>
    </body>
</html>

