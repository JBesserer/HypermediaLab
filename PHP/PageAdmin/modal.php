<?php
echo "
                            <div id='myModal' class='modal fade' role='dialog'>
                              <div class='modal-dialog'>
                                <div class='modal-content'>
                                  <div class='modal-body'>
                                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                    <h4 class='modal-title'>Ajouter la période et un code pour appliquer la promotion choisie</h4>
                                    <p>Le code n'est pas obligatoire et ne sera pas exigé si le champ est vide</p>
                                    <form id = 'formPromotion' action='javascript:;' method='post' enctype='multipart/form-data' accept-charset='utf-8'> 
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