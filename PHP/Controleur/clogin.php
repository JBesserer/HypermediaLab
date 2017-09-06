<?php
/****************************************************************
		Fichier : clogin.php
		Auteur : Jérémy Besserer-Lemay
		Fonctionnalité : Controleur de login
			Date: 2017-08-23
			
			Dernière modification:
			2017-08-23      Jérémy Besserer-Lemay   1 Creation
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
	
	class controleurConnexion{
		private $infoUser;
		private $gestionnaireConn;
		function __construct() {
            $this->gestionnaireConn = new gestionnaireConnexion();
			$this->infoUser = [];
			$this->infoUser[0] = isset($_POST['courriel']) ? $_POST['courriel'] : null;
			$this->infoUser[1] = isset($_POST['motdepasse']) ? $_POST['motdepasse'] : null;
		}
		//Entre les informations de la connection dans le gestionnaire de connection
		function websiteConnection(){
			return $this->gestionnaireConn->websiteConnection($this->infoUser);
		}
                
                function echoInfos(){
                    echo $this->infoUser[0];
                    echo $this->infoUser[1];
                }
	}
	
	//Si la vueConnexion a bien ete submitter
	
	$utilisateurCourant = new utilisateur();
	$controlConn = new controleurConnexion();
	$utilisateurCourant = $controlConn->websiteConnection();  
        
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
                        header("Location: http://localhost/PHP/PageClient/catalogue");
                        exit;
                    }

            }
            else{
                    header("Location: http://localhost/PHP/PageCommune/login?erreur=1");
                  
                    exit;
            }
?>

