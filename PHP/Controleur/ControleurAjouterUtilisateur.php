<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
require_once '../objet/tilisateur.php';
require_once '../Gestionnaire/GestionnaireUtilisateur.php';
require_once '../PageClient/profilInscrip.php';
/**
 * Description of ControleurAjouteurUtilisateur
 *
 * @author barilpi
 */
class ControleurAjouterUtilisateur {
   private $infosUtilisateur=[];
   private $gestionnaireUtilisateur;
           
   function __construct() {
        $this->infosUtilisateur[0] = isset($_POST['id_client']) ? $_POST['id_client'] : null;
        $this->infosUtilisateur[1] = isset($_POST['nom_client']) ? $_POST['nom_client'] : null;
        $this->infosUtilisateur[2] = isset($_POST['prenom_client']) ? $_POST['prenom_client'] : null;
        $this->infosUtilisateur[3] = isset($_POST['numero_telephone']) ? $_POST['numero_telephone'] : null;
        $this->infosUtilisateur[4] = isset($_POST['courriel']) ? $_POST['courriel'] : null;
        $this->infosUtilisateur[5] = isset($_POST['mot_passe']) ? $_POST['mot_passe'] : null;
        $this->gestionnaireUtilisateur = new GestionnaireUtilisateur();
   }
   
   function ajouterUtilisateur(){
       $this->gestionnaireUtilisateur->ajouterUtilisateur($this->infosUtilisateur);
   }
   
}

$controlAjoutUtilisateur = new ControleurAjouterUtilisateur();
$controlAjoutUtilisateur->ajouterUtilisateur();

$conn = new ControleurAjouterUtilisateur();

if($conn !== null)
{ 
header("Location: http://localhost/Presentation/VueGestionnaireUtilisateur");
exit;
}
?>
