<?php
/****************************************************************
		Fichier : gServicePromotion.php
		Auteur : Jeremy Besserer-Lemay
		Fonctionnalité : gestionnaire modif de service
			Date: 2017-09-30
			
			Dernière modification:
			2017-09-30     Jeremy-Besserer-Lemay   1 Creation
 ******************************************************************/
require_once '../MoteurBD/moteurBD.php';

class gServicePromotion {
    private $sql;
    
    function __construct() {
        $this->sql = new moteurBD();
    }
   
   function ajouterServicePromotion(array $service)
   {
       return $this->sql->ajouterServicePromotion($service);       
   }  
   
   function modifierServicePromotion(array $service)
   {
       return $this->sql->modifierServicePromotion($service);       
   }  
   function supprimerServicePromotion($service)
   {
       return $this->sql->supprimerServicePromotion($service);       
   }  
}
