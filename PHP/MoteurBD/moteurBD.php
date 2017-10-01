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
     * Retourne un client et ses infos
     * @param $idclient 
     */
    function selectClient($idClient) {

        $mysqli = $this->connection();

        //MySqli Select Query
        $results = $mysqli->query("SELECT a.prenom, a.nom, a.telephone, a.infolettre, b.no_civique, b.rue, b.code_postal, c.ville, d.courriel, d.mot_de_passe FROM client a INNER JOIN adresse b ON a.fk_adresse = b.pk_adresse INNER JOIN ville c ON b.fk_ville=c.pk_ville INNER JOIN utilisateur d ON d.pk_utilisateur= a.fk_utilisateur WHERE a.pk_client='" . $idClient . "'");
        $numClient = array();
        while ($row = $results->fetch_assoc()) {
            $numClient[] = array(
                'prenom_client' => $row['prenom'],
                'nom_client' => $row['nom'],
                'numero_telephone' => $row['telephone'],
                'infolettre' => $row['infolettre'],
                'no_civique' => $row['no_civique'],
                'rue' => $row['rue'],
                'code_postal' => $row['code_postal'],
                'ville' => $row['ville'],
                'courriel' => $row['courriel'],
                'mot_de_passe' => $row['mot_de_passe']
            );
        }
        // Frees the memory associated with a result
        $results->free();

        // close connection
        $mysqli->close();
        return $numClient;
    }
    
    function selectUtilisateur($courrielClient) {

        $mysqli = $this->connection();

        //MySqli Select Query
        $results = $mysqli->query("SELECT * FROM utilisateur WHERE courriel= '" . $courrielClient . "'");
        $mysqli->close();
         if($results->num_rows === 0)
        {
            return false;
        }
        else return true;
      
    }
    
    function getIdClient($courrielClient){
        $mysqli = $this->connection();

        //MySqli Select Query
        $results = $mysqli->query("SELECT a.pk_client FROM client a INNER JOIN utilisateur b ON a.fk_utilisateur=b.pk_utilisateur WHERE b.courriel= '".$courrielClient."'");
        $idClient = array();
        while ($row = $results->fetch_assoc()) {
            $idClient[] = array(
                'id_client' => $row['pk_client']
            );
        }
        // Frees the memory associated with a result
        $results->free();

        // close connection
        $mysqli->close();
        return $idClient;
    }

    /**
     * Insere un nouveau client dans la BD
     * @param array $clientpour les infos clients à entrer
     */
    function insertUtilisateur(array $client) {
        $erreur = 0;
        $mysqli = $this->connection();
        $idVille;

        $clientSelect = $this->selectUtilisateur($client[7]);
        
        if($clientSelect === true){
            $erreur = 1;
            return $erreur;
        }
        else
        {
     
            $mysqli->autocommit(TRUE);
            $res= $mysqli->query("SELECT pk_ville FROM ville WHERE ville = '" . $client[4] . "';"   );
            //echo "ID ville".$idVille;
            if (mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_assoc($res)) {
               $idVille = $row["pk_ville"];
            }
         }
            echo "numero ville".$idVille;
            $res1=$mysqli->query("INSERT INTO adresse (no_civique, rue, fk_ville, code_postal) VALUES ('" . $client[2] . "','" . $client[3] . "','" .$idVille."','". $client[5]."')");
            $idAdresse=$mysqli->insert_id;
            echo "adresse:".$idAdresse;
            $res2=$mysqli->query("INSERT INTO utilisateur (courriel, mot_de_passe, administrateur) VALUES ('" . $client[7] . "','" . $client[8] . "', 0);");
            $idUtilisateur=$mysqli->insert_id;
            $res3=$mysqli->query("INSERT INTO client (fk_utilisateur, prenom, nom, fk_adresse, telephone, infolettre) VALUES ('".$idUtilisateur."' ,'" . $client[0] . "', '" . $client[1] . "','" . $idAdresse ."','" . $client[6] . "', '" . $client[9] . "')"); 
        
        }
        // close connection
        $mysqli->close();
        if($idVille===false){
            $erreur=1;
        }else if($res1===false){
            $erreur=2;
        }else if($res2===false){
            $erreur=3;
        }else if($res3===false){
            $erreur=4;
        }
        return $erreur;
    }
    
    /**
     * Met à jour les informations d'un client
     * @param array $client
     */
    function updateClient(array $client) {

        $erreur=0;
        $mysqli = $this->connection();
        $idAdresse;
        $idUtilisateur;
        $idVille;
        
        $resultId = $this->getIdClient($_SESSION["Courriel"]);
        $idClient = $resultId[0]["id_client"];
        
        $res= $mysqli->query("SELECT pk_ville FROM ville WHERE ville = '" . $client[4] . "';"   );
            //echo "ID ville".$idVille;
            if (mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_assoc($res)) {
               $idVille = $row["pk_ville"];
            }
         }
        
        $result=$mysqli->query("UPDATE client SET prenom='" . $client[0] . "', nom='" . $client[1] . "', telephone='" . $client[6] . "', infolettre='" . $client[9] . "' WHERE pk_client='" . $idClient . "'");
        
        $res= $mysqli->query("SELECT fk_adresse FROM client WHERE pk_client='" . $idClient . "'");
            if (mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_assoc($res)) {
               $idAdresse = $row["fk_adresse"];
            }
         }
         $res= $mysqli->query("SELECT fk_utilisateur FROM client WHERE pk_client='" . $idClient . "'");
            if (mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_assoc($res)) {
               $idUtilisateur = $row["fk_utilisateur"];
            }
         }
        
        $result=$mysqli->query("UPDATE utilisateur SET courriel='" . $client[7] . "', mot_de_passe='" . $client[8] . "' WHERE pk_utilisateur='" . $idUtilisateur . "'");
        $result=$mysqli->query("UPDATE adresse SET no_civique='" . $client[2] . "', rue='" . $client[3] . "', code_postal='" . $client[5] . "', fk_ville='" . $idVille . "' WHERE pk_adresse='" . $idAdresse . "'");
        $result=$mysqli->query("UPDATE ville SET ville='" . $client[4] . "' WHERE pk_ville='" . $idVille . "'");
         

        if($result===false){
            $erreur=5;
        }
        
        // close connection
        $mysqli->close();
        
        return $erreur;
    }
    
    
}//fin de la classe moteurBD
