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
        
        $mysqli->set_charset("utf8");
        
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
        $mysqli->set_charset("utf8");
        //MySqli Select Query
        $results = $mysqli->query("SELECT * FROM service WHERE actif = 1 ORDER BY service_titre");

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
    
    function populateAdminCatalogue(){
        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");
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
    function populateFacture() {

        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");

        //MySqli Select Query
        $results = $mysqli->query("SELECT facture.pk_facture,facture.date_service, facture.no_confirmation, ta_facture_service.tarif_facture, ta_facture_service.montant_rabais, client.prenom, client.nom, service.service_titre, promotion.promotion_titre, promotion.rabais FROM `ta_facture_service` JOIN facture ON facture.pk_facture = ta_facture_service.fk_facture JOIN client ON facture.fk_client = client.pk_client JOIN service ON service.pk_service = ta_facture_service.fk_service LEFT JOIN ta_promotion_service ON ta_promotion_service.fk_service = service.pk_service LEFT JOIN promotion ON promotion.pk_promotion = ta_promotion_service.fk_promotion ORDER BY facture.date_service DESC");

        $allfacture = array();
        while ($row = $results->fetch_assoc()) {
            $allfacture[] = array(
                'facture.pk_facture' => $row['pk_facture'],
                'facture.date_service' => $row['date_service'],
                'facture.no_confirmation' => $row['no_confirmation'],
                'ta_facture_service.tarif_facture' => $row['tarif_facture'],
                'ta_facture_service.montant_rabais' => $row['montant_rabais'],
                'client.prenom' => $row['prenom'],
                'client.nom' => $row['nom'],
                'service.service_titre' => $row['service_titre'],
                'promotion.promotion_titre' => $row['promotion_titre'],
                'promotion.rabais' => $row['rabais']
            );
        }
        // Frees the memory associated with a result
        $results->free();

        // close connection
        $mysqli->close();
        return $allfacture;
    }
    
    function populateRabais(){
        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");

        //MySqli Select Query
        $results = $mysqli->query("SELECT promotion.pk_promotion, promotion.promotion_titre, promotion.rabais, service.pk_service, ta_promotion_service.date_debut, ta_promotion_service.date_fin, ta_promotion_service.pk_promotion_service FROM promotion JOIN ta_promotion_service ON promotion.pk_promotion = ta_promotion_service.fk_promotion JOIN service ON ta_promotion_service.fk_service = service.pk_service");

        $allrabais = array();
        while ($row = $results->fetch_assoc()) {
            $allrabais[] = array(
                'pk_promotion' => $row['pk_promotion'],
                'promotion_titre' => $row['promotion_titre'],
                'rabais' => $row['rabais'],
                'pk_service' => $row['pk_service'],
                'date_debut' => $row['date_debut'],
                'date_fin' => $row['date_fin'],
                'pk_promotion_service' => $row['pk_promotion_service']
            );
        }
        // Frees the memory associated with a result
        $results->free();

        // close connection
        $mysqli->close();
        return $allrabais;
    }
    
    function getPromotions(){
        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");
        
        //MySqliSelectQuery
        $results = $mysqli->query("SELECT * FROM promotion");
        $allrabais = array();
        while ($row = $results->fetch_assoc()) {
            $allrabais[] = array(
                'pk_promotion' => $row['pk_promotion'],
                'promotion_titre' => $row['promotion_titre'],
                'rabais' => $row['rabais']
            );
        }
        // Frees the memory associated with a result
        $results->free();

        // close connection
        $mysqli->close();
        return $allrabais;    
    }
    
    function getService($idService)
    {
        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");

        //MySqli Select Query
        $results = $mysqli->query("SELECT * FROM `service` WHERE pk_service ='".$idService."'");

        $service = array();
        while ($row = $results->fetch_assoc()) {
            $service[] = array(
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
        return $service;
    }
    
    function modifierService(array$service){
        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");

        //MySqli Select Query
        $mysqli->query("UPDATE service SET service_titre='" . $service[2] . "', service_description='" . $service[3] . "', duree='" . $service[4] . "', tarif='" . $service[5] . "', actif='" . $service[6] . "' WHERE pk_service='" . $service[1] . "'");

        // close connection
        $mysqli->close();
        return 1;
    }
    
    function modifierServicePlusImg(array $service){
        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");

        //MySqli Select Query
        $mysqli->query("UPDATE service SET service_titre='" . $service[2] . "', service_description='" . $service[3] . "', duree='" . $service[4] . "', tarif='" . $service[5] . "', actif='" . $service[6] . "', image='" . $service[0] . "' WHERE pk_service='" . $service[1] . "'");

        // close connection
        $mysqli->close();
        return 1;
    }
    
    function ajoutServicePlusImg(array $service) {
        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");
        //MySqli Select Query
        $mysqli->query("INSERT INTO service (service_titre, service_description, duree, tarif, actif, image) VALUES ('" . $service[1] . "', '" . $service[2] . "', '" . $service[3] . "', '" . $service[4] . "','" . $service[5] . "','" . $service[0] . "')"); 
        
        
        // close connection
        $mysqli->close();
        
        return 1;
    }
    
    function ajoutService(array $service) {
        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");
        //MySqli Select Query
        $mysqli->query("INSERT INTO service (service_titre, service_description, duree, tarif, actif) VALUES ('" . $service[1] . "', '" . $service[2] . "', '" . $service[3] . "', '" . $service[4] . "','" . $service[5] . "')"); 
        
        
        // close connection
        $mysqli->close();
        
        return 1;
    }
    
    function activateService($service_id){
        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");
        
        $mysqli->query("UPDATE service SET actif= 1 WHERE pk_service='" . $service_id . "'");
        
        // close connection
        $mysqli->close();
    }
    
    function deactivateService($service_id){
        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");
        
        $mysqli->query("UPDATE service SET actif= 0 WHERE pk_service='" . $service_id . "'");
        
        // close connection
        $mysqli->close();
    }
    
    function ajouterServicePromotion(array $servicePromotion){
        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");
        //MySqli Select Query
        $mysqli->query("INSERT INTO ta_promotion_service (fk_promotion, fk_service, date_debut, date_fin, code) VALUES ('" . $servicePromotion[1] . "', '" . $servicePromotion[2] . "', '" . $servicePromotion[5] . "', '" . $servicePromotion[6] . "','" . $servicePromotion[7] . "')"); 
        
        
        // close connection
        $mysqli->close();
        
        return 1;
    }
    
    function modifierServicePromotion(array $servicePromotion){
        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");
        //MySqli Select Query
        $mysqli->query("UPDATE ta_promotion_service SET fk_promotion='" . $servicePromotion[1] . "', fk_service='" . $servicePromotion[2] . "', date_debut='" . $servicePromotion[5] . "', date_fin='" . $servicePromotion[6] . "', code='" . $servicePromotion[7] . "' WHERE pk_promotion_service='" . $servicePromotion[0] . "'"); 
        
        
        // close connection
        $mysqli->close();
        
        return 1;
    }
    
    function supprimerServicePromotion($servicePromotion){
        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");
        //MySqli Select Query
        $mysqli->query("DELETE FROM ta_promotion_service WHERE pk_promotion_service='" . $servicePromotion . "'"); 
        
        
        // close connection
        $mysqli->close();
        
        return 1;
    }
    
	
    /**
     * Retourne un client et ses infos
     * @param $idclient 
     */
    function selectClient($idclient) {

        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");

        //MySqli Select Query
        $results = $mysqli->query("SELECT * FROM client WHERE id_client='" . $idclient . "'");

        $allclient = array();
        while ($row = $results->fetch_assoc()) {
            $allclient[] = array(
                'id_client' => $row['id_client'],
                'nom_client' => $row['nom_client'],
                'prenom_client' => $row['prenom_client'],
                'numero_telephone' => $row['numero_telephone'],
                'courriel' => $row['courriel'],
                'mot_passe' => $row['mot_passe']
            );
        }
        // Frees the memory associated with a result
        $results->free();

        // close connection
        $mysqli->close();
        return $allclient;
    }

    /**
     * Insere un nouveau client dans la BD
     * @param array $clientpour les infos clients à entrer
     */
    function insertClient(array $client) {
        $erreur = 0;
        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");

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
        $mysqli->set_charset("utf8");
        
        $mysqli->query("UPDATE client SET nom_client='" . $client[1] . "', prenom_client='" . $client[2] . "', numero_telephone='" . $client[3] . "', courriel='" . $client[4] . "', mot_passe='" . $client[5] . "' WHERE id_client='" . $client[0] . "'");
        
        // close connection
        $mysqli->close();
    }
}//fin de la classe moteurBD
