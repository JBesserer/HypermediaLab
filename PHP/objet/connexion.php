<?php
/****************************************************************
		Fichier : connexion.php
		Auteur : Jérémy Besserer-Lemay
		Fonctionnalité : Prep Work pour la connexion au site web
			Date: 2017-04-11

			Vérification:
			2017-04-11      Jérémy Besserer-Lemay   Approuvé
			======================================================
			
			Historique de modifications:
			2017-04-11      Jérémy Besserer-Lemay   No Description
*****************************************************************/
	class connexion{
		private $nomUtilisateur; //String
		private $motPasse;	 //String
		
		public function __construct() {
			
		}
		
		public function getNomUtilisateur(){
			return $this->nomUtilisateur;
		}
		
		public function getMotPasse(){
			return $this->motPasse;
		}
		
		public function setNomUtilisateur($nomUtilisateur){
			$this->nomUtilisateur = $nomUtilisateur;
		}
		
		public function setMotPasse($motPasse){
			$this->motPasse = $motPasse;
		}
		
	}
?>