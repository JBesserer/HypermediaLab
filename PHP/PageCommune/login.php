<?php
/****************************************************************
Fichier : login.php
Auteur : Jérémy Besserer-Lemay
Fonctionnalité : Authentification pour le site web
Date: 2017-08-26

Vérification:

Historique de modifications:
2017-08-26      Jérémy Besserer-Lemay  1 Création
 *                      2017-09-04      Pierre-Marc Baril      2 Session réparée
 ******************************************************************/
// Start the session
session_start();
if (session_status() == true) {
    $_SESSION["loggedIn"] = false;
    session_unset();
    session_destroy();
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
<script>

    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1618496484887128',
            cookie     : true,  // enable cookies to allow the server to access
            xfbml      : true,  // parse social plugins on this page
            version    : 'v2.8' // use graph api version 2.8
        });
    };


</script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/fr_CA/sdk.js#xfbml=1&version=v2.10&appId=1618496484887128";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));



    function login() {
        FB.login(function(response) {
            if (response.authResponse) {
                console.log(response.email);
                window.top.location = "http://localhost/PHP/PageClient/catalogue.php";

            }
        }, {scope: 'public_profile,email'});
    }

    function logout() {
        FB.logout(function(response) {
            // user is now logged out
        });
    }


    function test(){
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                FB.api('/me', {fields: 'email'}, function(response) {
                    var email = response.email;
                    window.location.href = "http://localhost/PHP/Controleur/clogin.php?courrielFacebook=" + email;
                });
                console.log(response);
            }
        });
    }



</script>


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
    <div class="fb-login-button" data-scope="email" data-width="300" data-max-rows="1" data-size="large" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false" onlogin="test();"></div>
<!--</div>-->
<!--<fb:login-button autologoutlink="true"></fb:login-button>-->
<!--</div>-->
</body>
</html>




