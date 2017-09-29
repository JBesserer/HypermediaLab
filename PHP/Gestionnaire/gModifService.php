<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
