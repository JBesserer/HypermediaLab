<?php
/****************************************************************
		Fichier : confirmation.php
		Auteur : Pierre-Marc Baril
		Fonctionnalité : Gestionnaire des confirmations d'achat
			Date: 2017-08-26

			Vérification:

			Historique de modifications:
			2017-08-26      Pierre-Marc Baril   1 Création
 ******************************************************************/
<?php
echo "
        <div id='modalConfirmService' class='modal fade' role='dialog'>
          <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
              <div class='modal-body'>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <form id='formService' action='javascript:;' method='post' enctype='multipart/form-data' accept-charset='utf-8'> 
                    <div id='produitCat'>
                        <div class='divIDServiceModal'> 
                            <input type='text' value='0'name='idService' id='idService'>
                        </div>
                        <div class='col-sm-9 col-md-9 col-lg-9'>
                            <p>Nom du service</p>
                        </div>
                        <div class='col-sm-3 col-md-3 col-lg-3'>
                            <p>Prix du service</p>
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
