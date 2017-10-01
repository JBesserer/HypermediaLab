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
 *                      2017-09-28      Jeremy Besserer-Lemay   2 Consolidation des informations
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
        $results = $mysqli->query("SELECT * FROM promotion ORDER BY promotion_titre");
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
    
    function getServices(){
        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");

        //MySqli Select Query
        $results = $mysqli->query("SELECT * FROM `service`");

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
    
    
    function updatePromotion(array $services){
        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");
        $size = sizeof($services);
        
        for($i=0;$i<$size;$i++){
            if($services[$i][0]==null){
                $mysqli->query("INSERT INTO promotion (promotion_titre, rabais) VALUES ('" . $services[$i][1] . "', '" . $services[$i][2] . "')");
            }else{
                $mysqli->query("UPDATE promotion SET promotion_titre='" . $services[$i][1] . "', rabais='" . $services[$i][2] . "' WHERE pk_promotion='" . $services[$i][0] . "'");
            }
        }
        
        // close connection
        $mysqli->close();
        
        return 1;
    }
    
    function addToAllServices(array $promotionAllService){
        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");
        
        $services = $this->getServices();
        $size = sizeof($services);
        
        for($i=0;$i<$size;$i++){
            $mysqli->query("INSERT INTO ta_promotion_service (fk_promotion, fk_service,date_debut,date_fin,code) VALUES ('" . $promotionAllService[0] . "', '" . $services[$i]['pk_service'] . "', '" . $promotionAllService[1] ."', '" . $promotionAllService[2] ."', '" . $promotionAllService[3] ."')");
        }
        
        // close connection
        $mysqli->close();
        
        return 1;
    }
    
    function deletePromotion($promoID){
        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");
        
        //MySqli Select Query
        $mysqli->query("DELETE FROM ta_promotion_service WHERE fk_promotion='" . $promoID . "'"); 
        $mysqli->query("DELETE FROM promotion WHERE pk_promotion='" . $promoID . "'"); 
        
        
        // close connection
        $mysqli->close();
        
        return 1;
    }
	
    /**
     * Retourne un client et ses infos
     * @param $idclient 
     */
    function selectClient($idClient) {

        $mysqli = $this->connection();
        $mysqli->set_charset("utf8");

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
        $mysqli->set_charset("utf8");

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
        $mysqli->set_charset("utf8");

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
        $mysqli->set_charset("utf8");
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
        $mysqli->set_charset("utf8");
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
