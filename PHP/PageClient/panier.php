<?php
/****************************************************************
Fichier : panier.php
Auteur : Jeremy Besserer-Lemay
Fonctionnalité : Gestionnaire du catalogue des produits
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
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php
include ('../PageInject/EnteteClient.php');
include ('../MoteurBD/moteurBD.php');

$moteur = new moteurBD();
$services = $moteur->populateCatalogue();
$rabais = $moteur->populateRabais();

$max = sizeof($services);
$maxRabais = sizeof($rabais);
$sizeFacture = sizeof($_SESSION['idProduct']);
var_dump($sizeFacture);
$sousTotal = 0;
?>

<?php
for($i = 0; $i < $max;$i++)
{
    for($j =0; $j < $sizeFacture; $j++){
        if(strcmp($services[$i]['pk_service'], $_SESSION['idProduct'][$j])== 0){
            $sousTotal += $services[$i]['tarif'];
            echo "
            <div id='produitCat'>
                <div class='divIDCatalogue'> 
                    <p>" . $services[$i]['pk_service']."</p>
                </div>
                <div class='col-sm-2 col-md-2 col-lg-2'>
                    <img id='produitImage' src=". $services[$i]['image'].">
                </div>
                <div class='col-sm-10 col-md-10 col-lg-10 divContenuModalPanier'>
                    <div class='col-sm-10 col-md-10 col-lg-10 divContenu1'>
                        <p id='titreProd'>" . $services[$i]['service_titre']."</p> <br>
                    </div>
                    <div class='col-sm-2 col-md-2 col-lg-2 divContenu2'>
                        <p id='tarif'> Tarif : ".$services[$i]['tarif']."$</p> 
                    </div>";
            for($x = 0; $x < $maxRabais;$x++){
                if(strcmp($services[$i]['pk_service'], $rabais[$x]['pk_service'])== 0){
                    $prixPercent = 100 * (float)$rabais[$x]['rabais'];
                    $paymentDate = new DateTime();
                    $contractDateBegin = date_create(htmlentities(utf8_encode($rabais[$x]['date_debut']),0,'UTF-8'));
                    $contractDateEnd = date_create( htmlentities(utf8_encode($rabais[$x]['date_fin']),0,'UTF-8'));
                    $contractDateBegin = date_format($contractDateBegin,'Y-m-d');
                    $contractDateEnd = date_format($contractDateEnd,'Y-m-d');
                    $contractDateBegin = new DateTime($contractDateBegin);
                    $contractDateEnd = new DateTime($contractDateEnd);


                    if (($paymentDate->getTimestamp() >= $contractDateBegin->getTimestamp()) && ($paymentDate->getTimestamp() <= $contractDateEnd->getTimestamp()))
                    {
                        $prixRabais = (float)$rabais[$x]['rabais'] * $services[$i]['tarif'];
                        $sousTotal -= $prixRabais;
                        echo "
                            <div class='col-sm-10 col-md-10 col-lg-10 divContenu3'>
                                <p id='tarif'>".$rabais[$x]['promotion_titre']. " (".$prixPercent."%)</p>
                            </div>
                            <div class='col-sm-2 col-md-2 col-lg-2 divContenu4'>
                                <p id='tarif'> - ".$prixRabais."$</p> 
                            </div>";
                    }
                }
            }
            echo "
                </div>
            </div> ";
        }
    }
}

echo "<div class='col-sm-6 col-md-6 col-lg-6'>
            <form id='formUpdate'>
                <p> Entrer un code promotionnel pour profiter d'un rabais additionnel </p>
                <input type='text' name='codePromotionnel' id='codePromotionnel' required>
                <div class='col-sm-12 col-md-12 col-lg-12 confirmPositioning'>
                    <input type='submit' id='confirmer' class='confirmer' value='Confirmer'>
                </div>
            </form>
          </div>
          <div class='col-sm-4 col-md-4 col-lg-4'> </div>
          <div class='col-sm-2 col-md-2 col-lg-2'>
            <div class='col-sm-12 col-md-12 col-lg-12'>
                <p>Sous total: <span> ".$sousTotal."</span>$</p>
            </div>
            <div class='col-sm-12 col-md-12 col-lg-12'>
                <p>Rabais additionnel: <span>0</span>$</p>
            </div>
            <hr>
            <div class='col-sm-12 col-md-12 col-lg-12'>
                <p>Total: <span id='totalFacture'>".$sousTotal."</span>$</p>
            </div>
            <hr>
          </div>
          <div class='col-sm-12 col-md-12 col-lg-12 confirmPositioning'>
            <input type='button' id='confirmer' class='confirmer' value='Paiement'>
          </div>";

include('../PageClient/modalPanier.php');
?>

<script>
    $(document).ready(function(){
        var total = document.getElementById('totalFacture');

        $('.catalogue').css('color', '#FF4A07');

        $("#formUpdate").submit(function(e){
            var url = "../PageClient/updateTotal.php";
            var form = $('#formUpdate')[0];

            var formData = new FormData(form);
            $.ajax({
                type: "POST",
                url: url,
                data: formData, // serializes the form's elements.
                processData: false,
                contentType: false,
                success: function(data)
                {
                    console.log(data);
                }
            });
            e.preventDefault(); // avoid to execute the actual submit of the form.
        });
    });
</script>
</body>
</html>


