<?php
/****************************************************************
		Fichier : EnteteClient.php
		Auteur : Jeremy Besserer-Lemay
		Fonctionnalité : Entete 
			Date: 2017-08-26

			Vérification:

			Historique de modifications:
			2017-08-26      Jeremy Besserer-Lemay   1 Création
 ******************************************************************/
session_start();
?>
<header>
    <div class="topbar-nav">
        <a class='deconnecter' href='../PageCommune/login.php'>Se déconnecter </a>
        <a class="panier" href="../PageCommune/erreur404.php">Mon panier (0)</a><br>
        <a href="../PageCommune/login.php" ><img src="../images/icones/logo.png"></a>
        <img id='loupe' src='../images/icones/loupe.png'>
        <a class='profile' href="../PageClient/profilInscrip.php">Profil</a>
        <a class='catalogue' href='catalogue.php'>Catalogue</a> 
    </div>
</header>


