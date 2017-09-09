<?php
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