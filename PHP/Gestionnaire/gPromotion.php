<?php
/****************************************************************
		Fichier : gPromotion.php
		Auteur : Jeremy Besserer-Lemay
		Fonctionnalité : gestionnaire des promotions
			Date: 2017-10-01
			
			Dernière modification:
			2017-10-01     Jeremy-Besserer-Lemay   1 Creation
 ******************************************************************/
require_once '../MoteurBD/moteurBD.php';

class gPromotion {
    private $sql;
    
    function __construct() {
        $this->sql = new moteurBD();
    }
   
   function updatePromotion(array $promotions)
   {
       return $this->sql->updatePromotion($promotions);       
   }  
   
   function deletePromotion($promotionID)
   {
       return $this->sql->deletePromotion($promotionID);       
   }  
   
   function addToAllServices(array $promotionForAll)
   {
       return $this->sql->addToAllServices($promotionForAll);       
   }
}

