<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <link rel="stylesheet" href="css/General.css" />
  <link rel="stylesheet" href="css/info_perso.css" />
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
      <span class="text">Infos personnelles</span>
      <div id="root">
        <div id="generale" class="part">
          <h1 class="titre-part">Infos personnelles</h1>
          <?php
          $username = $_SESSION['username'];
          $pdo = getConnexion();
          $req = "SELECT URL from LOGINS
                  WHERE USERNAME = :username";
          $stmt = $pdo->prepare($req);
          $stmt->bindValue(":username", $username, PDO::PARAM_STR);
          $stmt->execute();
          $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
          $stmt->closeCursor();
          $_SESSION['URL'] =  $response[0]["URL"];
          ?>
          <div id="generale" class="part">
            <div id="part-G-infos" class="part-G-general">
              <div class="part-GG-infos">
                <p>Login :</p>
                <h2><?php echo $_SESSION['username'] ?></h2>
                <p>Mot de passe :</p>
                <h2 id="mdpCache"></h2>
              </div>
              <div class="part-GD-infos">
                <button id="modifier" class="modifier">Modifier</button>
                <button id="modifierMDP" class="modifierMDP">Modifier</button>
              </div>
            </div>
            <div id="part-D-infos" class="part-D-general">
              <div class="part-DG-infos">
                <img id="info_img" src="assets/Photos profil/<?php echo $_SESSION['URL'] ?>">
              </div>
              <div class="part-DD-infos">
                <p>Changer de photo :</p>
                <form id="form_img" action="upload.php" method="POST" enctype="multipart/form-data">
                  <label class="cache" for="file">Fichier</label>
                  <input type="file" name="file" required="Ce champs doit être rempli">
                  <div>
                    <button class="modifierPhoto" type="submit">Enregistrer</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div id="versement" class="part">
          <h1 class="titre-part">Mes Versements</h1>
          <div class=cadre-table-scroll>
            <table class="table-scroll">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Montant</th>
                  <th>Envoyeur</th>
                  <th>Receveur</th>
                  <th>Supprimer</th>
                <tr>
              </thead>
              <tbody id="infoTabVersement"></tbody>
            </table>
          </div>
          <button id="addVersement" class="addVersement">Ajouter versement</button>
        </div>
        <div id="change" class="part">
          <h1 id="changer" class="titre-part">Changer de coloc</h1>
          <h1 id="rejoindre" class="titre-part">Rejoindre une coloc</h1>
          <?php
          if ($_SESSION['role'] == 'Gerant coloc') {
          ?>
            <p class="messageErreur">/!\ Vous êtes gérant, vous ne pouvez donc pas changer de colocation sans effectuer de passation au préalable ! /!\</p>
          <?php
          } else {
          ?>
            <form id="form_coloc" action="http://localhost/api/updatecoloc" method="POST" enctype="multipart/form-data">
              <label for="coloc">Nouvelle colocation :</label>
              <input class="cache" type="number" name="id_personne" value=<?php echo $_SESSION['id_personne'] ?>>
              <SELECT id="select" name="coloc" size="1">
              </SELECT>
              <div>
                <button class="modifierColoc" type="submit">Enregistrer</button>
              </div>
            </form>
          <?php
          } ?>
        </div>
        <div id="coloc" class="part">
          <h1 class="titre-part">Quitter la coloc</h1>
          <?php
          if ($_SESSION['role'] == 'Gerant coloc') {
          ?>
            <p class="messageErreur">/!\ Vous êtes gérant, vous ne pouvez donc pas quitter votre colocation sans effectuer de passation au préalable ! /!\</p>
          <?php
          } else {
          ?>
            <form id="form_coloc" action="http://localhost/api/leavecoloc" method="POST" enctype="multipart/form-data">
              <label for="coloc">Pour quitter votre colocation, cliquez ici :</label>
              <input class="cache" type="number" name="id_personne" value=<?php echo $_SESSION['id_personne'] ?>>
              <div>
                <button class="modifierColoc" type="submit">Quitter</button>
              </div>
            </form>
          <?php
          } ?>
        </div>
      </div>
    </div>
  </section>
  <!------------------------------------- The Modal ------------------------------------->
  <!-- Changer login -->
  <div id="loginModal" class="modal">
    <div id="modal-contentprime">
      <span class="close2">&times;</span>
      <div id="modal-content">
        <div>
          <h1 id="modal_titre">Modification du login</h1>
        </div>
        <form id="form_login" action="upload.php" method="POST">
          <div class="change_mdp">
            <label for="login"> Nouveau login :</label>
            <input type="texte" minlength="4" maxlength="15" name="login" required="Ce champs doit être rempli">
          </div>
          <button class="modifierLOGIN2" type="submit">Modifier</button>
        </form>
      </div>
    </div>
  </div>
  <!-- Changer mot de passe -->
  <div id="mdpModal" class="modal1">
    <div id="modal-contentprime">
      <span class="close2">&times;</span>
      <div id="modal-content">
        <div>
          <h1 id="modal_titre">Changer de mot de passe :</h1>
        </div>
        <form id="form_change_mdp" action="upload.php" method="POST" onSubmit="return validate()">
          <div class="change_mdp">
            <label for="pass"> Nouveau mot de passe :</label>
            <input id="change_pass" type="texte" minlength="5" maxlength="15" name="pass" required="Ce champs doit être rempli">
          </div>
          <div class="change_mdp">
            <label for="pass"> Confirmer mot de passe :</label>
            <input id="change_pass2" type="texte" name="pass" required="Ce champs doit être rempli">
          </div>
          <button class="modifierMDP2" type="submit">changer</button>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal ajout versement -->
  <div id="versementModal" class="modal2">
    <div id="modal-contentprime-versement">
      <span class="close2">&times;</span>
      <div id="modal-content">
        <div>
          <h1 id="modal_titre_versement">Ajouter un versement</h1>
        </div>
        <form id="form_add_versement" action="http://localhost/api/versement" method="POST">
          <div class="add_versement_info">
            <label for="nom"> Envoyeur :</label>
            <input id="add_versement_info_personne" type="texte" name="personne" disabled="disabled">
          </div>
          <div class="add_versement_info">
            <label for="nom"> Receveur :</label>
            <SELECT id="select_membre" name="receveur" size="1" onchange="changeFunc();"></SELECT>
          </div>
          <div class="add_versement_info">
            <label for="montant"> Montant du versement :</label>
            <input type="number" name="montant" required="Ce champs doit être rempli">
          </div>
          <div class="add_versement_info">
            <label for="date"> Date versement :</label>
            <input type="date" name="date" required="Ce champs doit être rempli">
          </div>
          <div id="add_versement_info_ide" class="add_versement_info">
            <label for="id"> Id envoyeur:</label>
            <input type="number" name="id_envoyeur" value="<?php echo $_SESSION['id_personne']; ?>">
          </div>
          <div id="add_versement_info_idr" class="add_versement_info">
            <label for="id"> Id receveur:</label>
            <input id="add_versement_idr" type="number" name="id_receveur">
          </div>
          <button class="addVersement addVersement2" type="submit">Ajouter</button>
        </form>
      </div>
    </div>
  </div>
  <script>
    var id_personne = '<?php echo $_SESSION['id_personne']; ?>';
    var username = '<?php echo $_SESSION['username']; ?>';
    var password = '<?php echo $_SESSION['password']; ?>';
    var role = '<?php echo $_SESSION['role']; ?>';
  </script>
  <script src="js/General.js"></script>
  <script src="js/info_perso.js"></script>
</body>

</html>