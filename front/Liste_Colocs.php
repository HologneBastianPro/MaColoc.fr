<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <link rel="stylesheet" href="css/General.css" />
  <link rel="stylesheet" href="css/Liste_Colocs.css" />
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
  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu test'></i>
      <span class="text">Liste Colocs</span>
      <div id="root"></div>
  </section>
  <!-- The Modal -->
  <div id="myModal" class="modal">
    <div id="modal-contentprime">
      <span class="close2">&times;</span>
      <div id="modal-content">
        <div id="modal_titre"></div>
      </div>
    </div>
  </div>
  <!-- Recuperation image profil -->
  <script>
    var username = '<?php echo $_SESSION['username']; ?>';
    var role = '<?php echo $_SESSION['role']; ?>';
    var id_personne = '<?php echo $_SESSION['id_personne']; ?>';
  </script>
  <script src="js/General.js"></script>
  <script src="js/Liste_Colocs.js"></script>
</body>

</html>