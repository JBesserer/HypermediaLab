<?php
// Start the session
session_start();
if ($_SESSION["loggedIn"] == true) {
    $_SESSION["loggedIn"] = false;
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
        <link rel="stylesheet" href="../css/style.css">       
        <?php
        if(isset($_GET['erreur']))
            {
                $message = "Le nom d\'utilisateur ou le mot de passe est erronné.";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
        ?>
    </head>
    <body>
        <?php
        include ('../PageInject/EnteteNonConnect.php');
        ?>
        
        <p class='infoLogin'> Veuillez vous identifier pour avoir <br>la possibilité d'acheter des formations</p><br><br>
        
        <div id='theForm'>
            <form action="http://localhost/PHP/Controleur/clogin.php" method="post">
              <input type="text" name="courriel" id="courriel" placeholder="Courriel" size="45"> 
              <br><br>
              <input type="password" name="motdepasse" id="motdepasse" placeholder="Mot de passe" size="45">
              <br><br>
              <a class='oublie' href='../PageCommune/erreur404.php'>Mot de passe oublié</a>
              <br><br>
              <input type="submit" id="connexion" class="connexion" value="Connexion">
              <button type="button" name="inscrire" id="inscrire" onclick="location.href='../PageClient/profilInscrip.php';">S'inscrire</button>
            </form> 
            <br>
            <img id='facebook' src='../images/icones/facebook.png'>
        </div>
    </body>
</html>

