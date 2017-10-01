<?php
/****************************************************************
		Fichier : erreur404.php
		Auteur : Pierre-Marc Baril
		Fonctionnalité : Erreur 404
			Date: 2017-08-26

			Vérification:

			Historique de modifications:
			2017-08-26      Pierre-Marc Baril   1 Création
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
        <p class="chiffreErreur">ERREUR 404 </p>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <p class="lettreErreur">
            ON A VRAIMENT CHERCHÉ, MAIS LA PAGE N'A PU ÊTRE TROUVÉ 
            <br>
            ( ÊTES-VOUS SÛR D'ÊTRE À LA BONNE PLACE ? )
        </p>
    </body>
</html>