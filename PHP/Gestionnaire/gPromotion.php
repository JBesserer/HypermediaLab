<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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

