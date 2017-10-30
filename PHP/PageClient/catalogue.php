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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
            <div class='divIDCatalogue'> 
                <p>" . $services[$i]['pk_service']."</p>
            </div>
            <div class='col-sm-3 col-md-3 col-lg-3'>
                <img id='produitImage' src=". $services[$i]['image'].">
            </div>
            <div class='col-sm-7 col-md-7 col-lg-7 divContenuModalPanier'>
                <div class='col-sm-12 col-md-12 col-lg-12 divContenu1'>
                    <p id='titreProd'>" . $services[$i]['service_titre']."</p> <br>
                    <p id='descProd'>".$services[$i]['service_description']."</p><br>
                </div>
                <div class='col-sm-6 col-md-6 col-lg-6 divContenu2'>
                    <p id='tarif'> Tarif : ".$services[$i]['tarif']."$</p> 
                </div>
                <div class='col-sm-6 col-md-6 col-lg-6 divContenu3'>
                    <p id='duree'> Duree: ".$services[$i]['duree']."h </p>
                </div>
            </div>
            <div class='bottom-align-text col-sm-2 col-md-2 col-lg-2'>
                <a href='#' class='panierLink'><img id='panierImg' src='../images/icones/panier.png'></a>
            </div>
        </div> ";
        }

        include('../PageClient/modalPanier.php');
        ?>
        
        <script>
        $(document).ready(function(){

            $('.catalogue').css('color', '#FF4A07');

            $('.panierLink').click(function(){

                var productID = $(this).parent('div').siblings('div.divIDCatalogue').children('p').text();
                var productTitle = $(this).parent('div').siblings('div.divContenuModalPanier').children('div.divContenu1').children('p#titreProd').text();
                var productTarif = $(this).parent('div').siblings('div.divContenuModalPanier').children('div.divContenu2').children('p#tarif').text();

                $('#idService').html(productID);
                $('#nomService').html(productTitle);
                $('#tarifService').html(productTarif);

                $("#modalPanier").modal();
            });

            $('#modalService').on('hidden.bs.modal', function (e) {
                $(this)
                    .find("input[type=text],textarea,input[type=date]")
                    .val('')
                    .end()
                    .find("input[type=checkbox], input[type=radio]")
                    .prop("checked", "")
                    .end();
                // remove "selected" from any options that might already be selected
                $('form option[selected="selected"]').each(
                    function() {
                        $(this).removeAttr('selected');
                    }
                );


                // mark the first option as selected
                $("formoption:first").attr('selected','selected');
            });

            $('#modalService').on('hide.bs.modal', function (e) {
                $(this)
                    .find("input[type=text],textarea,input[type=date]")
                    .val('')
                    .end()
                    .find("input[type=checkbox], input[type=radio]")
                    .prop("checked", "")
                    .end();
                // remove "selected" from any options that might already be selected
                $('form option[selected="selected"]').each(
                    function() {
                        $(this).removeAttr('selected');
                    }
                );


                // mark the first option as selected
                $("formoption:first").attr('selected','selected');
            });

            $('.btnConfirm').click(function(){

                var produitID;
                produitID = $('#idService').html();

                $.ajax({
                    url: '../PageClient/panierNumberConfirm.php',
                    type: 'POST',
                    data: { id: produitID },
                    success: function(data) {
                        console.log(data);
                        $('.panier').text('Mon panier ('+data+')');
                        $("#modalPanier").modal('hide');
                    },
                    error: function(){

                    }
                });
            });
        });
        </script>
    </body>
</html>

