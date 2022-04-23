<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <link rel="stylesheet" href="css/General.css" />
  <link rel="stylesheet" href="css/Ma_coloc.css" />
  <meta charset="UTF-8" />
  <!-- Import des icons -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="assets/favicon.png" />
  <title>MaColoc.fr</title>
</head>

<body>
  <?php
  include_once("calc.php");
  include_once("sidebar.php");
  ?>
  <!--LA-->
  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu test'></i>
      <span class="text">Ma Coloc</span>
      <div id="root">
        <?php
        if ($_SESSION['role'] == 'Sans coloc') {
        ?>
          <h2>Vous n'êtes membre d'aucune colocation :(</h2>
        <?php
        } else {
        ?>
          <div id="generale" class="part">
            <h1 class="titre-part">Infos Générales</h1>
            <div id='part-G-generale' class="part-G-general"></div>
            <div id='part-D-generale' class="part-D-general">
              <div id='part-DG-generale' class="part-DG-general">
                <p>Nom coloc :</p>
                <p>Adresse :</p>
                <p>Gérant :</p>
                <p>Membres :</p>
              </div>
              <div id='part-DD-generale' class="part-DD-general">
                <div id="part-DDH-generale" class="part-DDH-general"></div>
                <div id="part-DDB-generale" class="part-DDB-general"></div>
              </div>
            </div>
          </div>
          <div id="cagnotte" class="part">
            <h1 class="titre-part">Infos Cagnotte</h1>
            <div id="nonCagnotte">
              <p class="messageErreur">/!\ Cette colocation n'a pas encore de cagnotte /!\</p>
              <button id="addCagnotte" class="addApport">Créer une cagnotte</button>
            </div>
            <div id='part-G-cagnotte' class="part-G-general">
              <div id="graph" class="block minus3">
                <script src="https://code.highcharts.com/highcharts.js"></script>
                <script src="https://code.highcharts.com/highcharts-3d.js"></script>
                <script src="https://code.highcharts.com/modules/exporting.js"></script>
                <script src="https://code.highcharts.com/modules/export-data.js"></script>
                <script src="https://code.highcharts.com/modules/accessibility.js"></script>

                <figure class="highcharts-figure bgforce">
                  <div id="container"></div>
                </figure>
              </div>
            </div>
            <div id='part-D-cagnotte' class="part-D-general">
              <div id='part-DG-cagnotte' class="part-DG-general">
                <p class="libele-cagnotte">Nom Cagnotte :</p>
                <p class="libele-cagnotte">Créée par :</p>
                <br />
                <p class="libele-cagnotte">Solde actuel :</p>
              </div>
              <div id='part-DD-cagnotte' class="part-DD-general">
                <div id="part-DDH-cagnotte" class="part-DDH-general"></div>
                <div id="part-DDB-cagnotte" class="part-DDB-general"></div>
              </div>
            </div>
          </div>
          <div id="apport" class="part">
            <h1 class="titre-part">Les Apports</h1>
            <div class=cadre-table-scroll>
              <table class="table-scroll">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Personne</th>
                  <tr>
                </thead>
                <tbody id="infoTab"></tbody>
              </table>
            </div>
            <button id="addApport" class="addApport">Ajouter un apport</button>
          </div>
          <div id="achat" class="part">
            <h1 class="titre-part">Les Achats</h1>
            <div class=cadre-table-scroll>
              <table class="table-scroll">
                <thead>
                  <tr>
                    <th>Intitulé</th>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Personne</th>
                  <tr>
                </thead>
                <tbody id="infoTabAchat"></tbody>
              </table>
            </div>
            <button id="addAchat" class="addAchat">Ajouter un achat</button>
          </div>
          <div id="gestionColoc" class="part">
            <h1 id="titre-part-gestion">Gestion de la coloc</h1>
            <?php
            if ($_SESSION['role'] == 'Gerant coloc') {
            ?>
              <div id="part-G-gestion">
                <div id="part-GG-gestion">
                  <form id="form_coloc" action="http://localhost/api/updategerant" method="POST" enctype="multipart/form-data">
                    <div class="elementDiv">
                      <label for="id_colocation">Nouveau gérant :</label>
                      <SELECT id="select_personne" name="new_gerant" size="1"></SELECT>
                    </div>
                    <button class="nommerGerantBTN" type="submit">Nommer</button>
                    <div id="add_apport_info_idc" class="add_apport_info">
                      <label> Id coloc:</label>
                      <input id="add_info_idcoloc" type="number" name="id_colocation">
                    </div>
                  </form>
                </div>
                <div id="part-GD-gestion">
                  <form id="form_coloc2" action="http://localhost/api/delcoloc" method="POST" enctype="multipart/form-data">
                    <div class="elementDiv">
                      <label>Pour supprimer votre colocation appuyez ici :</label>
                    </div>
                    <button class="supprimerColocBTN" type="submit">Supprimer</button>
                    <div id="add_apport_info_idc" class="add_apport_info">
                      <label for="id_colocation"> Id coloc:</label>
                      <input id="add_info_idcoloc2" type="number" name="id_colocation">
                    </div>
                  </form>
                </div>
              </div>
              <div id="part-D-gestion">
                <form id="form_img" action="upload.php" method="POST" enctype="multipart/form-data">
                  <div class="elementDivPhoto">
                    <label class="cache" for="file">Changer la photo de la colocation :</label>
                    <input type="file" name="file_coloc">
                  </div>
                  <div id="gestion_photo_idcoloc" class="add_apport_info">
                    <label for=""> Id coloc:</label>
                    <input id="add_info_idcoloc4" type="number" name="id_colocation">
                  </div>
                  <button class="modifierPhoto" type="submit">Enregistrer</button>
                </form>
              </div>
            <?php
            }
            ?>
          </div>
          <!---------------------- Modals ---------------------->
          <!-- Modal ajout apport -->
          <div id="apportModal" class="modal">
            <div id="modal-contentprime">
              <span class="close2">&times;</span>
              <div id="modal-content">
                <div>
                  <h1 id="modal_titre">Ajouter un apport</h1>
                </div>
                <form id="form_add_apport" action="http://localhost/api/apport" method="POST">
                  <div class="add_apport_info">
                    <label for="date"> Date apport :</label>
                    <input type="date" name="date" required="Ce champs doit être rempli">
                  </div>
                  <div class="add_apport_info">
                    <label for="montant"> Montant de l'apport :</label>
                    <input type="number" name="montant" required="Ce champs doit être rempli">
                  </div>
                  <div class="add_apport_info">
                    <label for="personne"> Personne :</label>
                    <input id="add_apport_info_personne" type="texte" name="personne" disabled="disabled">
                  </div>
                  <div id="add_apport_info_id" class="add_apport_info">
                    <label for="id"> Id personne:</label>
                    <input type="number" name="id" value="<?php echo $_SESSION['id_personne']; ?>">
                  </div>
                  <div id="add_apport_info_idc" class="add_apport_info">
                    <label for="id_cagnotte"> Id cagnotte:</label>
                    <input id="add_info_cagnotte" type="number" name="id_cagnotte">
                  </div>
                  <button class="addApport addApport2" type="submit">Ajouter</button>
                </form>
              </div>
            </div>
          </div>
          <!-- Modal ajout achat -->
          <div id="achatModal" class="modal2">
            <div id="modal-contentprime">
              <span class="close2">&times;</span>
              <div id="modal-content">
                <div>
                  <h1 id="modal_titre_achat">Ajouter un achat</h1>
                </div>
                <form id="form_add_achat" action="http://localhost/api/achat" method="POST">
                  <div class="add_achat_info">
                    <label for="nom"> Intitulé :</label>
                    <input type="texte" name="nom" required="Ce champs doit être rempli">
                  </div>
                  <div class="add_achat_info">
                    <label for="date"> Date achat :</label>
                    <input type="date" name="date" required="Ce champs doit être rempli">
                  </div>
                  <div class="add_achat_info">
                    <label for="montant"> Montant de l'achat :</label>
                    <input type="number" name="montant" required="Ce champs doit être rempli">
                  </div>
                  <div class="add_achat_info">
                    <label for="personne"> Personne :</label>
                    <input id="add_achat_info_personne" type="texte" name="personne" disabled="disabled">
                  </div>
                  <div id="add_achat_info_id" class="add_achat_info">
                    <label for="id"> Id personne:</label>
                    <input type="number" name="id" value="<?php echo $_SESSION['id_personne']; ?>">
                  </div>
                  <div id="add_achat_info_idc" class="add_apport_info">
                    <label for="id_cagnotte"> Id cagnotte:</label>
                    <input id="add_info_cagnotte_achat" type="number" name="id_cagnotte">
                  </div>
                  <button class="addAchat addAchat2" type="submit">Ajouter</button>
                </form>
              </div>
            </div>
          </div>
          <!-- Modal ajout cagnotte -->
          <div id="cagnotteModal" class="modal1">
            <div id="modal-contentprime">
              <span class="close2">&times;</span>
              <div id="modal-content">
                <div>
                  <h1 id="modal_titre">Créer une cagnotte</h1>
                </div>
                <form id="form_add_apport" action="http://localhost/api/cagnotte" method="POST">
                  <div class="add_apport_info">
                    <label for="nomCagnotte"> Nom cagnotte :</label>
                    <input id="add_apport_info_personne" type="texte" name="nomCagnotte" required="Ce champs doit être rempli">
                  </div>
                  <div id="add_apport_info_id" class="add_apport_info">
                    <label for="id"> Id personne:</label>
                    <input type="number" name="id" value="<?php echo $_SESSION['id_personne']; ?>">
                  </div>
                  <div id="add_apport_info_idc" class="add_apport_info">
                    <label for="id_coloc3"> Id coloc:</label>
                    <input id="add_info_idcoloc3" type="number" name="id_coloc3">
                  </div>
                  <button class="addApport addApport2" type="submit">Ajouter</button>
                </form>
              </div>
            </div>
          </div>

        <?php
        }
        ?>
      </div>
    </div>
  </section>
  <script>
    var username = '<?php echo $_SESSION['username']; ?>';
    var id_personne = '<?php echo $_SESSION['id_personne']; ?>';
    var role = '<?php echo $_SESSION['role']; ?>';
  </script>
  <script src="js/Ma_Coloc.js"></script>
  <script src="js/General.js"></script>
</body>

</html>