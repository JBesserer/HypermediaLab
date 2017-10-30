<?php
echo "
        <div id='modalPanier' class='modal fade' role='dialog'>
          <div class='modal-dialog modal-lg'>
            <div class='modal-content modalPanier'>
              <div class='modal-body'>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <div id='divPanierModal'>
                    <div class='divIDServiceModal'> 
                        <p id='idService'></p>
                    </div>
                    <div class='col-sm-9 col-md-9 col-lg-9'>
                        <p id='nomService' class='infoClientNoir'></p>                      
                    </div>
                    <div class='col-sm-3 col-md-3 col-lg-3'>
                        <p id='tarifService' class='infoClientBleu'></p>
                    </div>
                    <div class='col-sm-12 col-md-12 col-lg-12 '>
                        <p class='infoClientJaune'>Vous ne serez plus jamais en difficulté dans ses compétences.</p>
                    </div>
                    <div class='col-sm-12 col-md-12 col-lg-12 confirmPositioning'>
                        <input type='button' id='confirmer' class='btnConfirm' value='Ajouter au panier'>
                    </div>
                </div>              
              </div>
            </div>
          </div>
        </div>";