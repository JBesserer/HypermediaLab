<?php
/****************************************************************
		Fichier : moteurBD.php
		Auteur : Jeremy Besserer-Lemay
		Fonctionnalité : Moteur des requêtes pour tous les gestionnaires
                                 et de jquery
			Date: 2017-08-26

			Vérification:

			Historique de modifications:
			2017-08-26      Jeremy Besserer-Lemay   1 Connexion et Client
 ******************************************************************/
/**
 * Classe moteurBD qui effectue la connextion avec la base de donnée "labo"
 */
class moteurBD {
    
    /**
     * Ouvre la connexion avec la base de donnée
     * @return con connexion mysqli
     */
    function connection() {
        $server = "localhost";
        $username = "root";
        $password = "";
        $dbname = "labo";

        $con = new mysqli($server, $username, $password, $dbname);

        //Output any connection error
        if ($con->connect_error) {
            die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }
        return $con;
    }
	
    //Verifie si l'utilisateur existe dans la base de donnees et retourne ses informations pour setter les informations dans la page
    function websiteConnection(connexion $infosConnexion)
    {
        $utilisateurCourant = new utilisateur();
        $mysqli = $this->connection();
        
        //MySqli Select Query
        $results = $mysqli->query("SELECT * FROM utilisateur WHERE courriel = '" . $infosConnexion->getNomUtilisateur() . "' AND mot_de_passe = '" . $infosConnexion->getMotPasse() . "'");
        
        if(!$results)
        {
            die('Les informations specifies sont invalides.' . mysql_error());
            
        }
        else{
            
            while ($row = $results->fetch_assoc()) {
                $utilisateurCourant->setTypeUser($row["administrateur"]);
            }    
        }	
       
        // Frees the memory associated with a result
        $results->free();
        
        // close connection
        $mysqli->close();  

		
	return $utilisateurCourant;
    }
    
    /**
     * Retourne un client et ses infos
     * @param $idclient 
     */
    function populateCatalogue() {

        $mysqli = $this->connection();

        //MySqli Select Query
        $results = $mysqli->query("SELECT * FROM service ORDER BY service_titre");

        $allservice = array();
        while ($row = $results->fetch_assoc()) {
            $allservice[] = array(
                'pk_service' => $row['pk_service'],
                'service_titre' => $row['service_titre'],
                'service_description' => $row['service_description'],
                'duree' => $row['duree'],
                'tarif' => $row['tarif'],
                'actif' => $row['actif'],
                'image' => $row['image']
            );
        }
        // Frees the memory associated with a result
        $results->free();

        // close connection
        $mysqli->close();
        return $allservice;
    }

    /**
     * Insere un nouveau client dans la BD
     * @param array $clientpour les infos clients à entrer
     */
    function insertClient(array $client) {
        $erreur = 0;
        $mysqli = $this->connection();

        $clientSelect = $this->selectClient($client[0]);
        if($clientSelect[0] !== null){
            $erreur = 1;
            return $erreur;
        }
        else
        {
            //MySqli Select Query
            $mysqli->query("INSERT INTO client (id_client, nom_client, prenom_client, numero_telephone, courriel, mot_passe) VALUES ('" . $client[0] . "', '" . $client[1] . "', '" . $client[2] . "', '" . $client[3] . "','" . $client[4] . "','" . $client[5] . "')"); 
        }
        
        // close connection
        $mysqli->close();
        
        return $erreur;
    }
    
    /**
     * Met à jour les informations d'un client
     * @param array $client
     */
    function updateClient(array $client) {

        $mysqli = $this->connection();
        
        $mysqli->query("UPDATE client SET nom_client='" . $client[1] . "', prenom_client='" . $client[2] . "', numero_telephone='" . $client[3] . "', courriel='" . $client[4] . "', mot_passe='" . $client[5] . "' WHERE id_client='" . $client[0] . "'");
        
        // close connection
        $mysqli->close();
    }
}//fin de la classe moteurBD
