<?php
/****************************************************************
		Fichier : GestionnaireUtilisateur.php
		Auteur : Pierre-Marc Baril
		Fonctionnalité : Gestionnaire des utilisateurs
			Date: 2017-08-23
			
			Dernière modification:
			2017-08-23      Pierre-Marc Baril   1 Creation
 ******************************************************************/
require_once '../MoteurBD/moteurBD.php';

class GestionnaireUtilisateur {
    private $sql;
    
    function __construct() {
        $this->sql = new moteurBD();
    }
        
   function ajouterUtilisateur(array $client)
   {
       return $this->sql->insertUtilisateur($client);
   }
   
   function modificationUtilisateur(array $client)
   {
       return $this->sql->updateClient($client);
   }
   
   function supprimerUtilisateur(array $client)
   {
       $this->sql->supprimerUtilisateur($client);       
   }  
}