<?php
    class utilisateur{
        private $nomUtilisateur; //String
        private $motPasse;	 //String
        private $type_user;      //int

        public function __construct() {

        }

        public function getNomUtilisateur(){
                return $this->nomUtilisateur;
        }

        public function getMotPasse(){
                return $this->motPasse;
        }
        
        public function getTypeUser(){
                return $this->type_user;
        }

        public function setNomUtilisateur($nomUtilisateur){
                $this->nomUtilisateur = $nomUtilisateur;
        }

        public function setMotPasse($motPasse){
                $this->motPasse = $motPasse;
        }
        
        public function setTypeUser($type_user){
                $this->type_user = $type_user;
        }

    }
?>

