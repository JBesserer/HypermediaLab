<?php
/****************************************************************
		Fichier : facture.php
		Auteur : Jeremy Besserer-Lemay
		Fonctionnalité : Gestionnaire des factures
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="../js/toggleFacture.js"></script>
    </head>
    <body>
        <?php
        include ('../PageInject/EnteteAdmin.php');
        include ('../MoteurBD/moteurBD.php');
        $moteur = new moteurBD();
        $factures = $moteur->populateFacture();
        $max = sizeof($factures);
        $prixArray = array();
        for($i = 0; $i< $max;$i++){
            if(strcmp($factures[$i]['facture.pk_facture'], $factures[$i-1]['facture.pk_facture'])!== 0){
                $prixArray[$i]=(float)$factures[$i]['ta_facture_service.tarif_facture'];
                if($factures[$i]['promotion.rabais'] !== null && strcmp($factures[$i]['ta_facture_service.montant_rabais'],'0.00') !== 0 ){
                    $prixArray[$i]-= (float)$factures[$i]['ta_facture_service.tarif_facture']*(float)$factures[$i]['promotion.rabais'];
                }
            }
            else{
                $prixArray[$i-1]+= (float)$factures[$i]['ta_facture_service.tarif_facture'];
                if($factures[$i]['promotion.rabais'] !== null && strcmp($factures[$i]['ta_facture_service.montant_rabais'],'0.00') !== 0){
                    $prixArray[$i-1]-= (float)$factures[$i]['ta_facture_service.tarif_facture']*(float)$factures[$i]['promotion.rabais'];
                }  
            }
        }
        ?>
        
        <?php
        for($i = 0; $i < $max;$i++)
        {        
            if(strcmp($factures[$i]['facture.pk_facture'], $factures[$i-1]['facture.pk_facture'])!== 0){
                $date = date_create(htmlentities(utf8_encode($factures[$i]['facture.date_service']),0,'UTF-8'));
            echo "
            <div id='produitCat'>";
            echo"
                    <p id='numFacture'>". htmlentities(utf8_encode($factures[$i]['facture.pk_facture']),0,'UTF-8')."</p>
                    <div id='contenuFacture'>
                    <p id='nomClient'>" . $factures[$i]['client.prenom']." ". $factures[$i]['client.nom']." <span id='dateFacture'>". date_format($date,"d/m/Y")."</span></p> <br>
                    <p id='descFacture'>". strtoupper($factures[$i]['facture.no_confirmation']) ."<span id='prixFacture'>". htmlentities(number_format(utf8_encode($prixArray[$i]),2,'.',''),0,'UTF-8')."$</span></p><br>
                    <div class='divItems'>
                    <p id='item'>" . $factures[$i]['service.service_titre']."<span id='prixFacture'>". htmlentities(utf8_encode($factures[$i]['ta_facture_service.tarif_facture']),0,'UTF-8')."$</span> </p>" ;

                    if($factures[$i]['promotion.rabais'] !== null && strcmp($factures[$i]['ta_facture_service.montant_rabais'],'0.00') !== 0){
                        $rabais = 100 * (float)$factures[$i]['promotion.rabais'];
                        echo "<p id='rabais'>".$factures[$i]['promotion.promotion_titre']." (".$rabais."%)<span id='prixFacture'>-". $factures[$i]['ta_facture_service.montant_rabais']."$</span></p>";
                    }

            }
            
            else{          
               echo "<p id='item'>". $factures[$i]['service.service_titre'] ."<span id='prixFacture'>". $factures[$i]['ta_facture_service.tarif_facture']."$</span></p><br>";
               if($factures[$i]['promotion.rabais'] !== null && strcmp($factures[$i]['ta_facture_service.montant_rabais'],'0.00') !== 0){
                        $rabais = 100 * (float)$factures[$i]['promotion.rabais'];
                        echo "<p id='rabais'>".$factures[$i]['promotion.promotion_titre']." (".$rabais."%)<span id='prixFacture'>-". $factures[$i]['ta_facture_service.montant_rabais']."$</span></p>";
               }
            }
            if(strcmp($factures[$i]['facture.pk_facture'], $factures[$i+1]['facture.pk_facture'])!== 0){

                echo "</div>";
                echo "</div> ";
                echo "<div id='detailFacture'> <a href='#' class='detail'>Détails</a> </div>";
                echo "</div>";
            }
        }
        ?>
    </body>
</html>



