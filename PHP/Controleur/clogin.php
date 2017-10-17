<?php
/****************************************************************
Fichier : clogin.php
Auteur : Jérémy Besserer-Lemay
Fonctionnalité : Controleur de login
Date: 2017-08-23

Dernière modification:
2017-08-23      Jérémy Besserer-Lemay   1 Creation
 *                      2017-09-29      Pierre-Marc Baril       2 Connexion fonctionnelle
 ******************************************************************/
// Start the session
session_start();
if(isset($_GET['erreur']))
{
    $message = "Le nom d\'utilisateur ou le mot de passe est erronné.";
    echo "<script type='text/javascript'>alert('$message');</script>";
}

?>
<?php
require_once '../Gestionnaire/glogin.php';
require_once '../objet/utilisateur.php';
require_once '../MoteurBD/moteurBD.php';

$moteur = new moteurBD();
$erreur;

class controleurConnexion{
    private $infoUser;
    private $gestionnaireConn;
    function __construct() {

        $this->gestionnaireConn = new gestionnaireConnexion();
        $this->infoUser = [];
        $this->infoUser[0] = isset($_POST['courriel']) ? $_POST['courriel'] : null;
        $this->infoUser[1] = isset($_POST['motdepasse']) ? $_POST['motdepasse'] : null;

        if(isset($_GET['courrielFacebook'])){
            $this->infoUser[0] = isset($_GET['courrielFacebook']) ? $_GET['courrielFacebook'] : null;
            $erreur=2;
        }
    }


    //Entre les informations de la connection dans le gestionnaire de connection
    function websiteConnection(){
        $erreur=4;
        return $this->gestionnaireConn->websiteConnection($this->infoUser);
    }

    //Entre les informations de la connection dans le gestionnaire de connection
    function websiteConnectionFacebook(){
        $erreur=5;
        return $this->gestionnaireConn->websiteConnectionFacebook($this->infoUser);
    }

    function echoInfos(){
        echo $this->infoUser[0];
        echo $this->infoUser[1];
    }

    function getCourriel(){
        return $this->infoUser[0];
    }
}

//Si la vueConnexion a bien ete submitter

$utilisateurCourant = new utilisateur();
$controlConn = new controleurConnexion();
if(isset($_GET['courrielFacebook'])) {
    $utilisateurCourant = $controlConn->websiteConnectionFacebook();
}else {
    $utilisateurCourant = $controlConn->websiteConnection();
}





if($utilisateurCourant->getTypeUser() != null)
{
    $_SESSION["loggedIn"]= true;
    if($utilisateurCourant->getTypeUser() == 1){
        $_SESSION["typeUtilisateur"] = "Admin";
        header("Location: http://localhost/PHP/PageAdmin/service");
        exit;
    }
    else{
        $_SESSION["typeUtilisateur"] = "User";
        $_SESSION["Courriel"] = $controlConn->getCourriel();
        $_SESSION["idClient"] = $moteur->getIdClient($_SESSION["Courriel"]);
        header("Location: http://localhost/PHP/PageClient/catalogue");
        exit;
    }

}
else if(isset($_GET['courrielFacebook'])) {
    header("Location: http://localhost/PHP/PageClient/profilInscrip.php?emailFacebook=" . $_GET['courrielFacebook']);
    exit;
}else {
    header("Location: http://localhost/PHP/PageCommune/login?erreur=1");
    exit;
}

?>

