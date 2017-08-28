<?php
/****************************************************************
		Fichier : ControleurAjouterVehicule.php
		Auteur : Jérémy Besserer-Lemay
		Fonctionnalité : Controleur de la vue Ajouter Vehicule
			Date: 2017-04-11

			Vérification:
			2017-04-11      Jérémy Besserer-Lemay   Approuvé
			======================================================
			
			Dernière modification:
			2017-04-12      Jérémy Besserer-Lemay   No Description
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
	require_once '../LogiqueAffaires/gestionnaireConnexion.php';
        require_once '../LogiqueAffaires/employe.php';
	require_once '../LogiqueAffaires/type_employe.php';
	
	class controleurConnexion{
		private $infoUser;
		private $gestionnaireConn;
		function __construct() {
            $this->gestionnaireConn = new gestionnaireConnexion();
			$this->infoUser = [];
			$this->infoUser[0] = isset($_POST['utilisateur']) ? $_POST['utilisateur'] : null;
			$this->infoUser[1] = isset($_POST['motpasse']) ? $_POST['motpasse'] : null;
		}
		//Entre les informations de la connection dans le gestionnaire de connection
		function websiteConnection(){
			return $this->gestionnaireConn->websiteConnection($this->infoUser);
		}
	}
	
	//Si la vueConnexion a bien ete submitter
	
	$utilisateurCourant = new employe();
	$controlConn = new controleurConnexion();
	$utilisateurCourant = $controlConn->websiteConnection();  
            if($utilisateurCourant->getIdEmploye() != null)
            {
                    $typeEmployeCourant = new type_employe();
                    $typeEmployeCourant = $utilisateurCourant->getTypeEmploye();
                    $_SESSION["loggedIn"]= true;
                    $_SESSION["employeNom"] = $utilisateurCourant->getNomEmploye();
                    $_SESSION["employePrenom"] = $utilisateurCourant->getPrenomEmploye();
                    $_SESSION["typeEmploye"] = $typeEmployeCourant->getIdTypeEmploye();
                    
                    header("Location: http://localhost/Presentation/VueAccueil");
                    exit;

            }
            else{
                    header("Location: http://localhost/Presentation/VueConnexion?erreur=1");
                  
                    exit;
            }
?>

