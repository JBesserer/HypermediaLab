<?php
/****************************************************************
		Fichier : profilInscrip.php
		Auteur : Pierre-Marc Baril
		Fonctionnalité : Gestionnaire d'inscription et de profil
			Date: 2017-08-26

			Vérification:

			Historique de modifications:
			2017-08-26      Pierre-Marc Baril   1 Création
 ******************************************************************/
session_start();
error_reporting(0);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <body>
        <script>
        $(document).ready(function(){
            $('.profile').css('color', '#FF4A07');  
        });
        </script>
        <?php
        if($_SESSION["loggedIn"]== true){
            include ('../MoteurBD/moteurBD.php');
            include ('../PageInject/EnteteClient.php');
            $idclient = $_SESSION["idClient"][0];
            $moteur = new moteurBD();
            $client = $moteur->selectClient($idclient['id_client']);
        }else{
            include ('../PageInject/EnteteNonConnect.php');
        }
        ?>
        
        
        
        
        
            <form id="formAjout" action="../Controleur/ControleurAjouterUtilisateur.php" method="post">
                <fieldset class="borderForm">

                    <p class="mainTextForm">Remplissez ce formulaire pour créer votre profil</p>
                    <p class="oblTextForm">Tous les champs sont obligatoires</p>
                    <input type="text" name="nomClient" id="nomClient" placeholder="Nom" size="45" class="inputText" required>
                    <input type="text" name="prenomClient" id="prenomClient" placeholder="Prenom" size="45" class="inputText" required> 
                    <br><br>

                    <input type="text" name="numCivic" id="numcivic" placeholder="No civic" size="15" class="inputText" required>
                    <input type="text" name="rue" id="rue" placeholder="Rue" size="26" class="inputText" required>
                    <select id="ville" name="ville" class="selectWidth" class="inputText" required>
                      <option value="" disabled selected hidden>Ville</option>
                      <option value="Sherbrooke">Sherbrooke</option>
                      <option value="Magog">Magog</option>
                      <option value="Orford">Orford</option>
                      <option value="North Hatley">North Hatley</option>
                      <option value="Windsor">Windsor</option>
                      <option value="Waterville">Waterville</option>
                      <option value="Saint-Denis-de-Brompton">Saint-Denis-de-Brompton</option>
                      <option value="Eastman">Eastman</option>
                      <option value="Racine">Racine</option>
                    </select> 
                    <br><br>

                    <input type="text" name="codePostal" id="codePostal" placeholder="Code Postal" size="45" class="inputText" pattern="([A-Za-z][0-9][A-Za-z][ -]?[0-9][A-Za-z][0-9])" required>
                    <input type="text" name="numTel" id="numTel" placeholder="Numéro de téléphone" size="45" pattern="\d{3}[\-]\d{3}[\-]\d{4}" class="inputText" title="Le format doit être 555-555-5555." required>
                    <br><br>
                    
                    <p class="mainTextForm">Votre courriel servira à vous identifier lors de votre prochaine visite</p>
                    <p class="oblTextForm">Le mot de passe doit contenir 1 chiffre, 1 lettre et 8 caractères au minimum</p>
                    <input type="text" name="courrielInsc" id="courrielInsc" placeholder="Courriel" size="45" class="inputText" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Veuillez écrire un courriel valide." required>
                    <input type="text" name="confCourriel" id="confCourriel" placeholder="Confirmation du courriel" size="45" onblur="confirmEmail()" class="inputText" required> 
                    <br><br>
                    
                    <input type="password" name="password" id="password" placeholder="Mot de passe" size="45" class="inputText" pattern="(?=.*[a-z]).{8,}" title="Le mot de passe doit contenir une lettre, un chiffre et au moins 8 caractères." required>
                    <input type="password" name="confPassword" id="confPassword" placeholder="Confirmation du mot de passe" size="45" onblur="confirmPass()" class="inputText" required> 
                    <br><br>
                    <input type="text" name="modifFormulaire" id="modifFormulaire" hidden="true" display="none" value="1">
                    
                    <label><input type="checkbox" name="checkboxInscrip" value="true" id="checkboxInscrip"> Souhaitez-vous recevoir les promotions et les nouveautés</label>   
                    <br><br>
                    <input type="submit" id="inscription" class="connexionRight" value="Inscription">
                    
              </fieldset>
                
            </form> 
        
        
        <script type="text/javascript" charset="utf-8">
            function remplirFormulaire(){
                var client = <?php echo json_encode($client, JSON_PRETTY_PRINT)?>;
                document.getElementById("nomClient").value = client[0]["nom_client"];
                document.getElementById("prenomClient").value = client[0]["prenom_client"];
                document.getElementById("numcivic").value=client[0]["no_civique"];
                document.getElementById("rue").value = client[0]["rue"];
                document.getElementById("ville").value =client[0]["ville"];
                document.getElementById("codePostal").value =client[0]["code_postal"];
                document.getElementById("numTel").value =client[0]["numero_telephone"];
                document.getElementById("courrielInsc").value =client[0]["courriel"];
                document.getElementById("confCourriel").value =client[0]["courriel"];
                document.getElementById("password").value =client[0]["mot_de_passe"];       
                document.getElementById("confPassword").value =client[0]["mot_de_passe"];
                if(parseInt(client[0]["infolettre"])===1){
                document.getElementById("checkboxInscrip").checked = true;
            }else {
                document.getElementById("checkboxInscrip").checked = false;
            }
            };
        </script>
        
        <script type="text/javascript" charset="utf-8">
            function hiddenButton(){
        document.getElementById("inscription").value = "Modification";
            };
        </script>
        
        <script type="text/javascript" charset="utf-8">
            function showButton(){
        document.getElementById("inscription").style.display = "block";
            };
            
            function modifForm(){
                document.getElementById("modifFormulaire").value = 2;
            }
        </script>
        
        <?php
        if($_SESSION["loggedIn"]== true){
            echo '<script type="text/javascript">',
                    'remplirFormulaire();',
                    '</script>';
            echo '<script type="text/javascript">',
                    'hiddenButton();',
                    '</script>';
            echo '<script type="text/javascript">',
                    'modifForm();',
                    '</script>';
            
        }else{
            echo '<script type="text/javascript">',
                    'showButton();',
                    '</script>';
        }
        ?>
        

        
        
    </body>
</html>





<script type="text/javascript" charset="utf-8">
    function confirmEmail() {
        var email = document.getElementById("courrielInsc").value
        var confemail = document.getElementById("confCourriel").value
        if(email != confemail) {
            alert('Les courriels ne sont pas identiques!');
            document.getElementById("courrielInsc").focus(); 
        }
    }
    
    function confirmPass() {
        var pass = document.getElementById("password").value
        var confPass = document.getElementById("confPassword").value
        if(pass != confPass) {
            alert('Les mots de passe ne sont pas identiques!');
            document.getElementById("password").focus(); 
        }
    }
    
    
    function modifForm(){
        document.getElementById("modifFormulaire").value = 2;
    }
    
       
    
</script>

