<?php

/****************************************************************
		Fichier : ControleurAjouterUtilisateur.php
		Auteur : Pierre-Marc Baril
		Fonctionnalité : Controleur d'ajout d'utilisateur
			Date: 2017-08-23
			
			Dernière modification:
			2017-08-23      Pierre-Marc Baril   1 Creation
 ******************************************************************/


require_once '../Gestionnaire/GestionnaireUtilisateur.php';
require_once '../MoteurBD/moteurBD.php';
session_start();
/**
 * Description of ControleurAjouteurUtilisateur
 * @author barilpi
 */

$moteur = new moteurBD();
class ControleurAjouterUtilisateur {
   private $infosUtilisateur=[];
   private $gestionnaireUtilisateur;
           
   function __construct() {
        $this->infosUtilisateur[0] = isset($_POST['prenomClient']) ? $_POST['prenomClient'] : null;
        $this->infosUtilisateur[1] = isset($_POST['nomClient']) ? $_POST['nomClient'] : null;
        $this->infosUtilisateur[2] = isset($_POST['numCivic']) ? $_POST['numCivic'] : null;
        $this->infosUtilisateur[3] = isset($_POST['rue']) ? $_POST['rue'] : null;
        $this->infosUtilisateur[4] = isset($_POST['ville']) ? $_POST['ville'] : null;
        $this->infosUtilisateur[5] = isset($_POST['codePostal']) ? $_POST['codePostal'] : null;
        $this->infosUtilisateur[6] = isset($_POST['numTel']) ? $_POST['numTel'] : null;
        $this->infosUtilisateur[7] = isset($_POST['confCourriel']) ? $_POST['confCourriel'] : null;
        $this->infosUtilisateur[8] = isset($_POST['confPassword']) ? $_POST['confPassword'] : null;
        $this->infosUtilisateur[9] = isset($_POST['checkboxInscrip']) ? 1 : 0;
        $this->infosUtilisateur[10] = isset($_POST['modifFormulaire']) ? $_POST['modifFormulaire'] : null;
        $this->gestionnaireUtilisateur = new GestionnaireUtilisateur();
   }
   
   function getModifForm(){
       return $this->infosUtilisateur[10];
   }
   
   function getCourriel(){
       return $this->infosUtilisateur[7];
   }
      
   function ajouterUtilisateur(){
       return $this->gestionnaireUtilisateur->ajouterUtilisateur($this->infosUtilisateur);
   }
   
   function modifierUtilisateur(){
       return $this->gestionnaireUtilisateur->modificationUtilisateur($this->infosUtilisateur);
   }
   
   
   function getPrenom(){
       return $this->infosUtilisateur[0];
   }
   
}

$controlUtilisateur = new ControleurAjouterUtilisateur();
$modification= $controlUtilisateur->getModifForm();
if($modification==1){
$conn = $controlUtilisateur->ajouterUtilisateur();
}else{    
$conn = $controlUtilisateur->modifierUtilisateur();
}


if($conn == 0)
{ 
    $message = "Votre compte a bien été enregistré!".$modification;
    echo "<script type='text/javascript'>alert('$message');window.location = '../PageCommune/login.php';</script>";
    exit;
}else if($conn == 1){
    $message = "Le courriel est déjà utilisé.".$modification;
    echo "<script type='text/javascript'>alert('$message');window.location = '../PageClient/profilInscrip.php';</script>";
}else if ($conn== 5){
    $message = "L'update n'a pas fonctionné.";
    echo "<script type='text/javascript'>alert('$message');window.location = '../PageClient/profilInscrip.php';</script>";
}
?>
