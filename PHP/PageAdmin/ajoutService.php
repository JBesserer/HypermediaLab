<?php
/****************************************************************
		Fichier : service.php
		Auteur : Jeremy Besserer-Lemay
		Fonctionnalité : Gestionnaire des services et promotions
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
        include ('../PageInject/EnteteAdmin.php');
        ?>
        
        <?php echo "
        <form action='http://localhost/PHP/Controleur/cAjoutService.php' method='post' enctype='multipart/form-data'> 
        <div id='produitCat'>
            <div class='col-sm-12 col-md-12 col-lg-12'>
                <p> Vous pouvez modifier les informations du service </p>
                <p> Tous les champs sont obligatoires </p>
            </div>
            <div class='col-sm-3 col-md-3 col-lg-3'>
                <img id='produitImage' src='../images/services/cours.gif'>
                <label class='btn btn-default btn-file' for='file'>
                    Mettre a jour l'image <input type='file' name='file' id='file' style='display: none;'>
                </label>
            </div>
            <div class='col-sm-9 col-md-9 col-lg-9'>
                <input type='text' name='nomService' id='nomService' placeholder='Nom du service' size='45' required><br>
                <textarea name='descService' id='descService' placeholder='Description du service' size='45' cols='40' rows='5' required></textarea> <br>
                <input type='text' name='heureService' id='heureService' placeholder='Nombre heures' size='30' pattern='\d+' required><span> h</span>
                <input type='text' name='tarifService' id='tarifService' placeholder='Tarif' size='30' pattern='\d*\.?\d*$' required> <span> $</span>
            </div>
            <div class='col-sm-3 col-md-3 col-lg-3'>
            </div>
            <div class='col-sm-9 col-md-9 col-lg-9'>
                <label><input type='checkbox' name='actif' id='actif'checked>Activer le service dans le catalogue</label>
            </div>
            <div class='col-sm-12 col-md-12 col-lg-12'>
                <input type='submit' id='confirmer' class='confirmer' value='Confirmer' required>
            </div>
        </div>
        </form>";
        ?>
        
        <script>
        $(document).ready(function(){
            $(function () {
                $("#file").change(function () {
                    if (this.files && this.files[0]) {
                        var reader = new FileReader();
                        reader.onload = imageIsLoaded;
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            });

            function imageIsLoaded(e) {
                $('#produitImage').attr('src', e.target.result);
            };
        });
        </script>
    </body>
</html>
