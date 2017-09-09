<?php
session_start();
error_reporting(0);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <?php
        if($_SESSION["loggedIn"]== true){
            include '../MoteurBD/moteurBD.php';
            include ('../PageInject/EnteteClient.php');
        }else{
            include ('../PageInject/EnteteNonConnect.php');
        }
        ?>
        
        <div>
            <form id="formAjout" action="ControleurAjouterClient.php" method="post" enctype="multipart/form-data">
                <fieldset class="borderForm">

                    <p class="mainTextForm">Remplissez ce formulaire pour créer votre profil</p>
                    <p class="oblTextForm">Tous les champs sont obligatoires</p>
                    <input type="text" name="nomClient" id="nomClient" placeholder="Nom" size="45" class="inputText">
                    <input type="text" name="prenomClient" id="prenomClient" placeholder="Prenom" size="45" class="inputText"> 
                    <br><br>

                    <input type="text" name="numCivic" id="numcivic" placeholder="No civic" size="15" class="inputText">
                    <input type="text" name="rue" id="rue" placeholder="Rue" size="26" class="inputText">
                    <select id="ville" class="selectWidth" class="inputText">
                      <option value="" disabled selected hidden>Ville</option>
                      <option value="troisrivieres">Trois-Rivières</option>
                      <option value="montreal">Montréal</option>
                      <option value="quebec">Québec</option>
                      <option value="village">Village lointain</option>
                    </select> 
                    <br><br>

                    <input type="text" name="codePostal" id="codePostal" placeholder="Code Postal" size="45" class="inputText">
                    <input type="text" name="numTel" id="numTel" placeholder="Numéro de téléphone" size="45" pattern="[1-9]{1}[0-9]{9}" class="inputText">
                    <br><br>
                    
                    <p class="mainTextForm">Votre courriel servira à vous identifier lors de votre prochaine visite</p>
                    <p class="oblTextForm">Le mot de passe doit contenir 1 chiffre, 1 lettre et 8 caractères au minimum</p>
                    <input type="text" name="courrielInsc" id="courrielInsc" placeholder="Courriel" size="45" class="inputText">
                    <input type="text" name="confCourriel" id="confCourriel" placeholder="Confirmation du courriel" size="45" onblur="confirmEmail()" class="inputText"> 
                    <br><br>
                    
                    <input type="password" name="password" id="password" placeholder="Mot de passe" size="45" class="inputText">
                    <input type="password" name="confPassword" id="confPassword" placeholder="Confirmation du mot de passe" size="45" onblur="confirmPass()" class="inputText"> 
                    <br><br>
                    
                    <label><input type="checkbox" name="vehicle" value="true" id="checkboxInscrip"> Souhaitez-vous recevoir les promotions et les nouveautés</label>   
                    <br><br>
                    <input type="submit" id="inscription" class="connexionRight" value="Inscription">
                    
              </fieldset>
                
            </form> 
        </div>
        
        <script type="text/javascript" charset="utf-8">
        function remplirFormulaire(){
        document.getElementById("nomClient").value ="John";
        document.getElementById("prenomClient").value ="Wick";
        document.getElementById("numcivic").value ="1303";
        document.getElementById("rue").value ="Rue John Smith";
        document.getElementById("ville").value ="quebec";
        document.getElementById("codePostal").value ="J1J1J1";
        document.getElementById("numTel").value ="8192694844";
        document.getElementById("courrielInsc").value ="john.wick@gmail.com";
        document.getElementById("confCourriel").value ="john.wick@gmail.com";
        document.getElementById("password").value ="Allo";        
        document.getElementById("confPassword").value ="Allo";    

        }   
    
        
        </script>

        <?php
        if($_SESSION["loggedIn"]== true){
            echo '<script type="text/javascript">',
                    'remplirFormulaire();',
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
    
    
       
    
</script>