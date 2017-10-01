<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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
