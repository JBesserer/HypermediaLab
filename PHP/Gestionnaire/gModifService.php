<?php
/****************************************************************
		Fichier : gModifService.php
		Auteur : Jeremy Besserer-Lemay
		Fonctionnalité : gestionnaire modif de service
			Date: 2017-09-30
			
			Dernière modification:
			2017-09-30     Jeremy-Besserer-Lemay   1 Creation
 ******************************************************************/

/**
 * Description of gModifService
 *
 * @author Jeremy
 */
require_once '../MoteurBD/moteurBD.php';

class gModifService {
    private $sql;
    
    function __construct() {
        $this->sql = new moteurBD();
    }
   
   function modifierServicePlusImg(array $service)
   {
       return $this->sql->modifierServicePlusImg($service);       
   }  
   
   function modifierService(array $service)
   {
       return $this->sql->modifierService($service);       
   }  
}
