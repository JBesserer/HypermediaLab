<?php
echo "
        <div id='modalService' class='modal fade' role='dialog'>
          <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
              <div class='modal-body'>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <form id='formService' action='javascript:;' method='post' enctype='multipart/form-data' accept-charset='utf-8'> 
                    <div id='produitCat'>
                        <div class='col-sm-12 col-md-12 col-lg-12'>
                            <p> Vous pouvez modifier les informations du service </p>
                            <p> Tous les champs sont obligatoires </p>
                        </div>
                        <div class='divIDServiceModal'> 
                            <input type='text' value='0'name='idService' id='idService'>
                        </div>
                        <div class='col-sm-3 col-md-3 col-lg-3'>
                            <img id='produitImageModal' src='../images/services/cours.gif'>
                            <label class='btn btn-default btn-file' for='file'>
                                Mettre a jour l'image <input type='file' name='file' id='file' style='display: none;'>
                            </label>
                        </div>
                        <div class='col-sm-9 col-md-9 col-lg-9'>
                            <input type='text' name='nomService' id='nomService' placeholder='Nom du service' size='45' required><br>
                            <textarea name='descService' id='descService' placeholder='Description du service' size='45' cols='40' rows='5' required></textarea> <br>
                            <input type='text' name='heureService' id='heureService' placeholder='Nombre heures' size='30' pattern='\d+' required><span> h</span>
                            <input type='text' name='tarifService' id='tarifService' placeholder='Tarif' size='30' pattern='\d*\.?\d*$' required> <span> $</span>
                        </div>
                        <div class='col-sm-3 col-md-3 col-lg-3'>
                        </div>
                        <div class='col-sm-9 col-md-9 col-lg-9'>
                            <label><input type='checkbox' name='actif' id='actif'checked>Activer le service dans le catalogue</label>
                        </div>
                        <div class='col-sm-12 col-md-12 col-lg-12 confirmPositioning'>
                            <input type='submit' id='confirmer' class='confirmer' value='Confirmer' required>
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