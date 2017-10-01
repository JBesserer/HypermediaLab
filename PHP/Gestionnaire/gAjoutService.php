<?php
/****************************************************************
		Fichier : gAjoutService.php
		Auteur : Jeremy Besserer-Lemay
		Fonctionnalité : gestionnaire d'ajout de service
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

class gAjoutService {
    private $sql;
    
    function __construct() {
        $this->sql = new moteurBD();
    }
   
   function ajoutServicePlusImg(array $service)
   {
       return $this->sql->ajoutServicePlusImg($service);       
   }  
   
   function ajoutService(array $service)
   {
       return $this->sql->ajoutService($service);       
   }  
}

