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

