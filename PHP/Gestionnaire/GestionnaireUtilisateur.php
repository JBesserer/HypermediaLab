<?php
/****************************************************************
		Fichier : GestionnaireUtilisateur.php
		Auteur : Pierre-Marc Baril
		Fonctionnalité : Gestionnaire des utilisateurs
			Date: 2017-08-23
			
			Dernière modification:
			2017-08-23      Pierre-Marc Baril   1 Creation
 ******************************************************************/
require_once '../objet/utilisateur.php';
require_once '../MoteurBD/moteurBD.php';

class GestionnaireUtilisateur {
    private $sql;
    
    function __construct() {
        $this->sql = new moteurBD();
    }
        
   function ajouterUtilisateur(array $client)
   {
       $this->sql->insertUtilisateur($client);
       $retour = $this->sql->selectUtilisateur($client[0]);
       return $retour;
   }
   
   function modifierUtilisateur(array $client)
   {
       $this->sql->updateUtilisateur($client);       
   }  
   
   function supprimerUtilisateur(array $client)
   {
       $this->sql->supprimerUtilisateur($client);       
   }  
}