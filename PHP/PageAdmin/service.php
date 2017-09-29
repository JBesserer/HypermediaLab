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
        $services = $moteur->populateCatalogue();
        $rabais = $moteur->populateRabais();
        $max = sizeof($services);
        $maxRabais = sizeof($rabais);
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
                <p class='promotion'>Promotions :</p>
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
                            <div id='promotionIcon' class='borderPromoCourante col-sm-1 col-md-1 col-lg-1'>
                                <div class='divIDRabais'> 
                                    <p>" . $rabais[$j]['pk_promotion']."</p>
                                </div>
                                <div class='dropdown'>
                                    <button class='btnDropdown' type='button' data-toggle='dropdown'>
                                    <span class='caret'></span></button>
                                    <ul class='dropdown-menu dropdown-menu-right'>
                                      <li><a href='#' class='modifierRabais'>Modifier la promotion</a></li>
                                      <li><a href='#' class='supprimerRabais'>Supprimer la promotion</a></li>
                                    </ul>
                                </div>
                                <p id='promoNumberText'>" . $prixPercent."%</p>
                                <div id='promotext'>
                                    <p> promotion </p>
                                </div>      
                            </div>";
                        }
                        else if($paymentDate->getTimestamp() < $contractDateBegin->getTimestamp()){
                            echo "
                            <div id='promotionIcon class='borderPromoFutur col-sm-1 col-md-1 col-lg-1'>
                                <div class='divIDRabais'> 
                                    <p>" . $rabais[$j]['pk_promotion']."</p>
                                </div>
                                <div class='dropdown'>
                                    <button class='btnDropdown' type='button' data-toggle='dropdown'>
                                    <span class='caret'></span></button>
                                    <ul class='dropdown-menu dropdown-menu-right'>
                                      <li><a href='#' class='modifierRabais'>Modifier la promotion</a></li>
                                      <li><a href='#' class='supprimerRabais'>Supprimer la promotion</a></li>
                                    </ul>
                                </div>
                                <p id='promoNumberText'>" . $prixPercent."%</p>
                                <div id='promotext'>
                                    <p> promotion </p>
                                </div>      
                            </div>";
                        }
                        else if($paymentDate->getTimestamp() > $contractDateEnd->getTimestamp()){
                            echo "
                            <div id='promotionIcon' class='borderPromoNonCourante col-sm-1 col-md-1 col-lg-1'>
                                <div class='divIDRabais'> 
                                    <p>" . $rabais[$j]['pk_promotion']."</p>
                                </div>
                                <div class='dropdown'>
                                    <button class='btnDropdown' type='button' data-toggle='dropdown'>
                                    <span class='caret'></span></button>
                                    <ul class='dropdown-menu dropdown-menu-right'>
                                      <li><a href='#' class='modifierRabais'>Modifier la promotion</a></li>
                                      <li><a href='#' class='supprimerRabais'>Supprimer la promotion</a></li>
                                    </ul>
                                </div>
                                <p id='promoNumberText'>" . $prixPercent."%</p>
                                <div id='promotext'>
                                    <p> promotion </p>
                                </div>      
                            </div>";
                        }
                    }
                }
                
                
                
                
            echo "
            <a href='#'>
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
                $(location).attr('href',"cToggleService.php?id="+value);
            });  
        });
        </script>
    </body>
</html>

