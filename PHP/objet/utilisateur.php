<?php
/****************************************************************
		Fichier : utilisateur.php
		Auteur : Jérémy Besserer-Lemay
		Fonctionnalité : Prep Work pour la connexion au site web
			Date: 2017-08-26

			Vérification:
			2017-08-26      Jérémy Besserer-Lemay   Approuvé
			======================================================
			
			Historique de modifications:
			2017-08-26      Jérémy Besserer-Lemay   No Description
*****************************************************************/
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

