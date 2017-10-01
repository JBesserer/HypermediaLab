<?php
/****************************************************************
		Fichier : promotion.php
		Auteur : Jeremy Besserer-Lemay
		Fonctionnalité : Page pour la gestion des promotions
			Date: 2017-10-01

			Vérification:

			Historique de modifications:
			2017-10-01      Jeremy Besserer-Lemay   1 Création
 ******************************************************************/
session_start();
error_reporting(0);
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
        include ('../PageInject/EnteteAdmin.php');
        include ('../MoteurBD/moteurBD.php');
        $moteur = new moteurBD();
        
        $promotions = $moteur->getPromotions();
        $maxPromotions = sizeof($promotions);
        
        ?>
        
        <?php
        echo "<div class='col-sm-12 col-md-12 col-lg-12 ajoutService'><a href='#' class='ajouter'>Ajouter une promotion</a></div>";
        echo "<form class='col-sm-12 col-md-12 col-lg-12 myForm' action='../Controleur/cPromotion.php' method='post' enctype='multipart/form-data'>";
        echo "<div class='formWrapper'>";
        for($i = 0; $i < $maxPromotions; $i++){
            $prixPercent = 100 * (float)$promotions[$i]['rabais'];
            echo "<div id='promotionCat'>
                <div class='divIDRabaisModal'> 
                    <input type='text' name='idRabaisModal".$i."' id='idRabaisModal' value='".$promotions[$i]['pk_promotion']."' placeholder='idRabaisModal'>
                    <p>".$promotions[$i]['pk_promotion']."</p>
                </div>
                <div class='col-sm-6 col-md-6 col-lg-6 marginPromoTitre'>
                    <input type='text' value='".$promotions[$i]['promotion_titre']."' id='promoTitre".$promotions[$i]['pk_promotion']."' readonly='readonly' name='promoTitre".$i."' required/>
                </div>
                <div class='col-sm-4 col-md-4 col-lg-4 marginPromoPercent'>
                    <input type='text' value='".$prixPercent."' readonly='readonly' id='promoPercent".$promotions[$i]['pk_promotion']."' name='promoPercent".$i."' required/><span>%</span>
                </div>
                <div class='col-sm-2 col-md-2 col-lg-2'> 
                    <div class='dropdown'>
                        <button class='btnDropdown' type='button' data-toggle='dropdown'>
                        <span class='caret'></span></button>
                        <ul class='dropdown-menu dropdown-menu-right'>
                          <li><a href='#' class='applyAll' >Appliquer à tous les services</a></li>
                          <li><a href='#' class='modifierRabais' >Modifier la promotion</a></li>
                          <li><a href='#' class='supprimerRabais'>Supprimer la promotion</a></li>
                        </ul>
                    </div>
                </div>
              </div>";
        }
        echo "</div>";        
        echo "<div class='col-sm-12 col-md-12 col-lg-12 confirmPositioning'>
                    <input type='submit' id='confirmer' class='confirmer' value='Confirmer'>
              </div>";
        echo "</form>";  
        
        echo "
                            <div id='myModal' class='modal fade' role='dialog'>
                              <div class='modal-dialog'>
                                <div class='modal-content'>
                                  <div class='modal-body'>
                                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                    <h4 class='modal-title'>Ajouter la période à la promotion choisie</h4>
                                    <form class='modalForm' action='../Controleur/cPromotion.php?eventid=1' method='post' enctype='multipart/form-data'> 
                                    <div id='produitCat'>
                                        <div class='divIDRabaisModalForm'> 
                                            <input type='text' name='idRabaisModalForm' id='idRabaisModalForm' placeholder='idRabaisModalForm'>
                                        </div>
                                        <div class='col-sm-12 col-md-12 col-lg-12'>
                                            <p> Vous pouvez choisir la période de temps pour la promotion avec tous les services </p>
                                            <p> Tous les champs sont obligatoires </p>
                                        </div>
                                        
                                        <div class='col-sm-12 col-md-12 col-lg-12'>
                                            <p>Période de la promotion</p>
                                            <input id='dateStart' name='dateStart' type='date' placeholder='Date de début' required>​<span> à </span>
                                            <input id='dateEnd' name='dateEnd' type='date' placeholder='Date de fin' required>​
                                            <p> Entrer un code s'il est requis pour appliquer la promotion lors de la création de la facture. </p>
                                            <input type='text' name='codePromo' id='codePromo'>
                                        </div>
                                        <div class='col-sm-12 col-md-12 col-lg-12 confirmPositioning'>
                                            <input type='submit' id='confirmer' class='confirmer' value='Confirmer'>
                                        </div>
                                    </div>
                                    </form>
                                    
                                  </div>
                                  <div class='modal-footer'>
                                    <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                                  </div>
                                </div>

                              </div>
                            </div>"   ;
        ?>
        
        
        <script>
        $(document).ready(function(){
            var resp = <?php echo json_encode($promotions);?>;
            var size = resp.length-1;
            $('.promotionWindow').css('color', '#FF4A07');
            $(".ajouter").click(function(){   
                size += 1;
                $('.formWrapper').append('<div id="promotionCat"><div class="divIDRabaisModal"><input type="text" name="idRabaisModal'+size+'" id="idRabaisModal" placeholder="0"></div><div class="col-sm-6 col-md-6 col-lg-6 marginPromoTitre"><input type="text" required placeholder="Titre de la promotion" name="promoTitre'+size+'" required/></div><div class="col-sm-4 col-md-4 col-lg-4 marginPromoPercent"><input type="text" placeholder="Rabais" name="promoPercent'+size+'" pattern="^[1-9][0-9]?$|^100$" required/><span>%</span></div><div class="col-sm-2 col-md-2 col-lg-2"> </div></div>')
            });
            $(".modifierRabais").click(function(){   
                var id = $(this).closest('div').parent().siblings('div.divIDRabaisModal').children('p').text();
                $('#promoTitre'+id+'').removeAttr("readonly");
                $('#promoPercent'+id+'').removeAttr("readonly");
            });
            
            $(".applyAll").click(function(){
                var idRabais = $(this).closest('div').parent().siblings('div.divIDRabaisModal').children('p').text();
                
                $('#idRabaisModalForm').val(idRabais);
                $("#myModal").modal();
            });
            
            $("form.modalForm").submit(function(e){
                var dateStart = $('#dateStart').val().replace('-','/').replace('-','/');
                var dateEnd = $('#dateEnd').val().replace('-','/').replace('-','/');
                if(dateStart >= dateEnd || dateEnd <= dateStart){
                    e.preventDefault();
                    alert("La date de départ ne peut pas être après la date de fin et vice versa.");
                }                 
            });  
            
            $('#myModal').on('hidden.bs.modal', function (e) {
            $(this)
              .find("input[type=text],textarea,input[type=date]")
                 .val('')
                 .end();
          ``});
      
            $(".supprimerRabais").click(function(){
                var idRabais = $(this).closest('div').parent().siblings('div.divIDRabaisModal').children('p').text();
                
                if(confirm("Voulez-vous vraiment supprimer cette promotion et tous ses liens?")){
                    $(location).attr('href',"../Controleur/cPromotion.php?id="+idRabais+"&eventid=2");
                }
                else{
                    return false;
                }
                
            }); 
            
        });
        </script>
    </body>
</html>

