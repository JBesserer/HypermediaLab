<?php
/****************************************************************
		Fichier : service.php
		Auteur : Jeremy Besserer-Lemay
		Fonctionnalité : Gestionnaire des services et promotions
			Date: 2017-08-26

			Vérification:

			Historique de modifications:
			2017-08-26      Jeremy Besserer-Lemay   1 Création
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
        $services = $moteur->populateAdminCatalogue();
        $rabais = $moteur->populateRabais();
        $promotions = $moteur->getPromotions();
        
        $max = sizeof($services);
        $maxRabais = sizeof($rabais);
        $maxPromotions = sizeof($promotions);
        ?>
        
        <?php
        echo "<div class='col-sm-12 col-md-12 col-lg-12 ajoutService'><a href='ajoutService.php' class='ajouter'>Ajouter un service</a></div>";
        for($i = 0; $i < $max;$i++)
        {
        if(strcmp($services[$i]['actif'],'1')== 0){
            echo "
            <div id='produitCat'>";
        }else{
            echo "
            <div id='produitCatDesactiver'>";
        }
        echo "
            <div class='divIDCatalogue'> 
                <p>" . htmlentities(utf8_encode($services[$i]['pk_service']),0,'UTF-8')."</p>
            </div>
            <div class='col-sm-3 col-md-3 col-lg-3'>
                <img id='produitImage' src=". $services[$i]['image'].">
                <br><br><br><br>
                <p class='promotion'>Promotions</p>
            </div>
            <div class='col-sm-7 col-md-7 col-lg-7'>
                <p id='titreProd'>" . $services[$i]['service_titre']."</p>
                <p id='descProd'>".$services[$i]['service_description']."</p><br>
                <p id='tarif'> Tarif : ".$services[$i]['tarif']."$</p> <p id='duree'> Duree: ".$services[$i]['duree']."h </p>";
                for($j = 0; $j < $maxRabais;$j++){
                    if(strcmp($services[$i]['pk_service'], $rabais[$j]['pk_service'])== 0){
                        $prixPercent = 100 * (float)$rabais[$j]['rabais'];
                        $paymentDate = new DateTime();
                        $contractDateBegin = date_create(htmlentities(utf8_encode($rabais[$j]['date_debut']),0,'UTF-8'));
                        $contractDateEnd = date_create( htmlentities(utf8_encode($rabais[$j]['date_fin']),0,'UTF-8'));
                        $contractDateBegin = date_format($contractDateBegin,'Y-m-d');
                        $contractDateEnd = date_format($contractDateEnd,'Y-m-d');
                        $contractDateBegin = new DateTime($contractDateBegin);
                        $contractDateEnd = new DateTime($contractDateEnd);
                        
                        if (($paymentDate->getTimestamp() >= $contractDateBegin->getTimestamp()) && ($paymentDate->getTimestamp() <= $contractDateEnd->getTimestamp()))
                        {
                            
                          echo "
                            <div id='promotionIcon' class='borderPromoCourante col-sm-1 col-md-1 col-lg-1'>";
                        }
                        else if($paymentDate->getTimestamp() < $contractDateBegin->getTimestamp()){
                            echo "
                            <div id='promotionIcon' class='borderPromoFutur col-sm-1 col-md-1 col-lg-1'>";
                        }
                        else if($paymentDate->getTimestamp() > $contractDateEnd->getTimestamp()){
                            echo "
                            <div id='promotionIcon' class='borderPromoNonCourante col-sm-1 col-md-1 col-lg-1'>";
                                
                        }
                        echo "
                        <div class='divIDRabais'> 
                                    <p class='idRabais'>" . $rabais[$j]['pk_promotion']."</p>
                                    <p class='idPromoService'>" . $rabais[$j]['pk_promotion_service']."</p>
                                    <p class='startDateRabais'>" .date_format($contractDateBegin, 'Y-m-d')."</p>
                                    <p class='endDateRabais'>" .date_format($contractDateEnd, 'Y-m-d')."</p>
                                    <p class='titreRabais'>" .$rabais[$j]['promotion_titre']."</p>
                                </div>
                                <div class='dropdown'>
                                    <button class='btnDropdown' type='button' data-toggle='dropdown'>
                                    <span class='caret'></span></button>
                                    <ul class='dropdown-menu dropdown-menu-right'>
                                      <li><a href='#' class='modifierRabais' >Modifier la promotion</a></li>
                                      <li><a href='#' class='supprimerRabais'>Supprimer la promotion</a></li>
                                    </ul>
                                </div>
                                <a href='#' data-toggle='tooltip' data-placement='top' class='noDeco' title='".date_format($contractDateBegin, 'Y-m-d')." au ".date_format($contractDateEnd, 'Y-m-d')."'>
                                <p id='promoNumberText'>" . $prixPercent."%</p>
                                <div id='promotext'>
                                    <p> promotion </p>
                                </div>
                                </a>
                            </div>";
                    }
                }
            echo "
                            <div id='myModal' class='modal fade' role='dialog'>
                              <div class='modal-dialog'>
                                <div class='modal-content'>
                                  <div class='modal-body'>
                                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                    <h4 class='modal-title'>Ajouter la période et un code pour appliquer la promotion choisie</h4>
                                    <p>Le code n'est pas obligatoire et ne sera pas exigé si le champ est vide</p>
                                    <form action='../Controleur/cServicePromotion.php' method='post' enctype='multipart/form-data'> 
                                    <div id='produitCat'>
                                        <div class='divIDRabaisModal'> 
                                            <input type='text' name='idServiceModal' id='idServiceModal' placeholder='idServiceModal'>
                                            <input type='text' name='idRabaisModal' id='idRabaisModal' placeholder='idRabaisModal'>
                                            <input type='text' name='idPromoServiceModal' id='idPromoServiceModal' placeholder='idPromoServiceModal'>
                                            <input type='text' name='percentSentData' id='percentSentData' placeholder='percentSentData'>
                                        </div>
                                        <div class='col-sm-12 col-md-12 col-lg-12'>
                                            <p> Vous pouvez modifier les informations du service </p>
                                            <p> Tous les champs sont obligatoires </p>
                                        </div>
                                        
                                        <div class='col-sm-3 col-md-3 col-lg-3 modPercentageText'>
                                            
                                            <p id='promoNumberText' class='percentagePromotion'></p>
                                            <select class='form-control selectPromo' name='selectPromo' required>
                                            <option disabled selected>Choisir une promotion</option>
                                        ";
                                            for($x = 0; $x < $maxPromotions;$x++){
                                                echo "<option>".$promotions[$x]['promotion_titre']."</option>";
                                            }
                                            
            echo "
                                            </select>
                                        </div>
                                        <div class='col-sm-9 col-md-9 col-lg-9'>
                                            <p>Période de la promotion</p>
                                            <input id='dateStart' name='dateStart' type='date' placeholder='Date de début' required>​<span> à </span>
                                            <input id='dateEnd' name='dateEnd' type='date' placeholder='Date de fin' required>​
                                            <p> Entrer un code s'il est requis pour appliquer la promotion lors de la création de la facture. </p>
                                            <input type='text' name='codePromo' id='codePromo'>
                                        </div>
                                        <div class='col-sm-3 col-md-3 col-lg-3'>
                                        </div>
                                        <div class='col-sm-12 col-md-12 col-lg-12'>
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
                
                
                
            echo "
            <a href='#' class='ajouterPromoService'>
            <div id='promotionPlus' class='col-sm-1 col-md-1 col-lg-1'>
                
                  <span class='glyphicon glyphicon-plus'></span>
                
            </div>
            </a>
            </div>
            <div class='bottom-align-text col-sm-2 col-md-2 col-lg-2'>
                <div class='dropdown'>
                    <button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>
                    <span class='caret'></span></button>
                    <ul class='dropdown-menu dropdown-menu-right'>
                      <li><a href='#' class='modifier'>Modifier le service</a></li>";
            if(strcmp($services[$i]['actif'],'1')== 0){
                echo "
                            <li><a href='#' class='desactiver'>Désactiver le service</a></li>
                          </ul>
                        </div>
                      <img class='reseauxSociaux' src='../images/icones/medias sociaux.jpeg'>
                  </div>
              </div> ";
            }else{
                echo "
                            <li><a href='#' class='desactiver'>Activer le service</a></li>
                          </ul>
                        </div>
                      <img class='reseauxSociaux' src='../images/icones/medias sociaux.jpeg'>
                  </div>
              </div> ";
            }
            
        }
        ?>
        
        <script>
        $(document).ready(function(){
            $(".modifier").click(function(){
                var value = $(this).parents('div').find('.divIDCatalogue').text();
                $(location).attr('href',"modifService.php?id="+value);
            });
            
            $(".desactiver").click(function(){
                var value = $(this).parents('div').find('.divIDCatalogue').text();
                $(location).attr('href',"../Controleur/cToggleService.php?id="+value);
            }); 
            
            $(".ajouterPromoService").click(function(){
                $('.percentagePromotion').html("0%");
                var idService = $(this).parents('div').find('.divIDCatalogue').text();
                var idRabais = $(this).parents('div').find('.divIDRabais').find('.idRabais').text();
                var idPromoService = $(this).parents('div').find('.divIDRabais').find('.idPromoService').text();
                
                $('#idServiceModal').val(idService);
                $('#idRabaisModal').val(idRabais);
                $('#idPromoServiceModal').val(idPromoService);
                $('select').attr('disabled',false);
                $("#myModal").modal();
            });
            
            $(".modifierRabais").click(function(){
                var idService = $(this).parents('div').find('.divIDCatalogue').text();
                var titreRabais = $(this).parents('div').find('.divIDRabais').find('.titreRabais').text();
                var percentage = $(this).parents('div').find('#promotionIcon').find('#promoNumberText').text();
                var idRabais = $(this).parents('div').find('.divIDRabais').find('.idRabais').text();
                var idPromoService = $(this).parents('div').find('.divIDRabais').find('.idPromoService').text();
                var dateStart = $(this).parents('div').find('.divIDRabais').find('.startDateRabais').text();
                var dateEnd = $(this).parents('div').find('.divIDRabais').find('.endDateRabais').text();
                
                $("select option").each(function(){
                    if($(this).val()==titreRabais){
                        $(this).attr("selected","selected");    
                    }
                });
                $('select').attr('disabled',true);
                $('.percentagePromotion').html(percentage);
                $('.idRabaisModal').html(idRabais);
                $('.idPromoServiceModal').html(idPromoService);
                
                
                $('#percentSentData').val(percentage);
                $('#idServiceModal').val(idService);
                $('#idRabaisModal').val(idRabais);
                $('#idPromoServiceModal').val(idPromoService);
                $('#dateStart').val(dateStart);
                $('#dateEnd').val(dateEnd);
                
                $("#myModal").modal();
            });  
            
            $(".supprimerRabais").click(function(){
                var pkPromoService = $(this).parents('div').find('.divIDRabais').find('.idPromoService').text();
                
                if(confirm("Voulez-vous vraiment supprimer cette promotion liée a ce service?")){
                    $(location).attr('href',"../Controleur/cServicePromotion.php?id="+pkPromoService+"&eventid=1");
                }
                else{
                    return false;
                }
                
            }); 
            
            $("form").submit(function(e){
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
                 .end()
              .find("input[type=checkbox], input[type=radio]")
                 .prop("checked", "")
                 .end();
                 // remove "selected" from any options that might already be selected
                $('form option[selected="selected"]').each(
                    function() {
                        $(this).removeAttr('selected');
                    }
                );


                // mark the first option as selected
                $("formoption:first").attr('selected','selected');
          ``});
            
            $('select').on('change', function() {
                var resp = <?php echo json_encode($promotions);?>;
                
                for(var x = 0; x < resp.length ;x++){
                    if(this.value == resp[x]['promotion_titre']){
                        var number =100*parseFloat(resp[x]['rabais'].toString());
                        $('.percentagePromotion').html(number+'%');
                        $('#percentSentData').val(number);
                        $('#idRabaisModal').val(resp[x]['pk_promotion']);
                    }
                }
             })
            $('[data-toggle="tooltip"]').tooltip();    
        });
        </script>
    </body>
</html>

