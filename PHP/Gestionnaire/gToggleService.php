<?php
/****************************************************************
		Fichier : gToggleService.php
		Auteur : Jeremy Besserer-Lemay
		Fonctionnalité : gestionnaire modif de service
			Date: 2017-09-30
			
			Dernière modification:
			2017-09-30     Jeremy-Besserer-Lemay   1 Creation
 ******************************************************************/
require_once '../MoteurBD/moteurBD.php';

class gToggleService {
    private $sql;
    
    function __construct() {
        $this->sql = new moteurBD();
    }
   
   function activateService($service)
   {
       return $this->sql->activateService($service);       
   }  
   
   function deactivateService($service)
   {
       return $this->sql->deactivateService($service);       
   }  
}
