<?php
/****************************************************************
Fichier : glogin.php
Auteur : Jérémy Besserer-Lemay
Fonctionnalité : Prep Work pour la connexion d'un utilisateur
Date: 2017-08-23


Historique de modifications:
2017-08-23      Jérémy Besserer-Lemay   No Description
 *****************************************************************/
require_once '../Controleur/clogin.php';
require_once '../MoteurBD/moteurBD.php';
require_once '../objet/connexion.php';
require_once '../objet/utilisateur.php';

class gestionnaireConnexion{
    private $moteurBD;
    private $infosConn;

    function __construct() {
        $this->infosConn = new connexion();
        $this->moteurBD = new moteurBD();
    }
    function websiteConnection(array $infosUser){
        $this->infosConn->setNomUtilisateur($infosUser[0]);
        $this->infosConn->setMotPasse($infosUser[1]);
        return $this->moteurBD->websiteConnection($this->infosConn);
    }

    function websiteConnectionFacebook(array $infosUser){
        $this->infosConn->setNomUtilisateur($infosUser[0]);
        return $this->moteurBD->websiteConnectionFacebook($this->infosConn);
    }
}
?>