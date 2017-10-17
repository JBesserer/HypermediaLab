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
    <script src="../js/serviceBaseJS.js"></script>

</head>
<body>
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1618496484887128',
            status     : true,
            cookie     : true,  // enable cookies to allow the server to access
            xfbml      : true,  // parse social plugins on this page
            version    : 'v2.10' // use graph api version 2.8
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));


</script>
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
echo "<div class='col-sm-12 col-md-12 col-lg-12 ajoutService'><a href='#' class='ajouter'>Ajouter un service</a></div>";
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
                <p>" . $services[$i]['pk_service']."</p>
            </div>
            <div class='divImageService col-sm-3 col-md-3 col-lg-3'>
                <img id='produitImage' src=". $services[$i]['image'].">
                <br><br><br><br>
                <p class='promotion'>Promotions</p>
            </div>
            <div class='divContenuService col-sm-7 col-md-7 col-lg-7'>
                <p id='titreProd'>" . $services[$i]['service_titre']."</p>
                <p id='descProd'>".$services[$i]['service_description']."</p><br>
                <p id='tarif'> Tarif : ".$services[$i]['tarif']."<span>$</span></p> <p id='duree'> Duree: ".$services[$i]['duree']." <span>h</span></p>";
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
                                    <button class='btnDropdown dropdown-toggle' type='button' data-toggle='dropdown'>
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
                      <a class='imageReseaux' href='#'><img id='reseauxSociaux' src='../images/icones/medias sociaux.jpeg'></a>
                  </div>
              </div> ";
    }else{
        echo "
                            <li><a href='#' class='desactiver'>Activer le service</a></li>
                          </ul>
                        </div>
                      <a class='imageReseaux' href='#'><img  id='reseauxSociaux' src='../images/icones/medias sociaux.jpeg'></a>
                  </div>
              </div> ";
    }

}
include ('../PageAdmin/modal.php');

include ('../PageAdmin/modalService.php');
?>

<script>
    $(document).ready(function(){
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
        });
        $(".imageReseaux").click(function(){
            var titreService = $(this).closest('div').siblings('.divContenuService').children('p#titreProd').text();
            var descService = $(this).closest('div').siblings('.divContenuService').children('p#descProd').text();
            var imgService = $(this).closest('div').siblings('.divImageService').children('img#produitImage').attr('src');
            var promoService = $(this).closest('div').siblings('.divContenuService').children('div.borderPromoCourante');
            if(promoService.length != 0){
                promoService = $(this).closest('div').siblings('.divContenuService').children('div.borderPromoCourante').children('a.noDeco').children('p#promoNumberText').text();
                titreService = titreService  + ' Promotion: '+promoService;
            }
            imgService = imgService.slice(2);
            imgService = 'http://locahost/PHP'+imgService;
            /*FB.ui({
                method: 'share',
                display: 'popup',
                href: 'https://developers.facebook.com/docs/',
            }, function(response){});*/

            FB.ui({
                method: 'share_open_graph',
                action_type:'og.shares',
                action_properties: JSON.stringify({
                    object:{
                        'og:url': 'http://localhost/PHP/PageClient/catalogue.php',
                        'og:title': titreService,
                        'og:description': descService,
                        'og:image':'https://static.pexels.com/photos/126407/pexels-photo-126407.jpeg', //Fake Cat Image
                        'og:image:width':'500',
                        'og:image:height':'300'

                    }
                })
            }, function(response) {
                if(response && response.post_id){}
                else{}
            });

        });


    });

    function shareFb(){
        var titreService = $(".reseauxSociaux").closest('div')
        $("meta[property='og\\:description']").attr("content", result.title);
    }
</script>

</body>
</html>

