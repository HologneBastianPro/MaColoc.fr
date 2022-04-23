<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/index.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <title>MaColoc.fr - Connexion</title>
</head>

<body>
  <?php
  //$url="https://bhologne.vvvpedago.enseirb-matmeca.fr/front/";
  $url = "http://localhost/front/";
  
  session_start();
  if (isset($_SESSION['username'])) {
    header("Location: " . $url . "Liste_Colocs.php");
  }
  ?>
    <div class="container2">
      <div class="logo">
        <i class='bx bx-home-smile'></i>
      </div>
      <div class="marque">
        <h4>MaColoc.fr</h4>
      </div>
      <div class="tab-body" data-id="connexion">
        <form id="formulaire" method="POST" action="login.php">
          <div class="row">
            <i class="bx bx-user"></i>
            <input type="text" class="input" name="username" placeholder="Login" required="required">
          </div>
          <div class="row">
            <i class="bx bx-lock"></i>
            <input placeholder="Mot de Passe" type="password" class="input" name="pass" required="required">
          </div>
          <input class="btn" type="submit" value="Connexion" name="submit">
        </form>
                 
      <?php
      if (isset($_SESSION['Error'])){
        ?>
        <div class="divError" >
        <?php echo $_SESSION['Error']; ?>
        </div>
        <?php

      }
      ?>
      </div>
      <div class="tab-body" data-id="inscription">
        <form method='POST' action="http://localhost/api/adduser">
          <div class="row">
            <i class="bx bx-user"></i>
            <input type="text" class="input" name="username" placeholder="Login" required="required">
          </div>
          <div class="row">
            <i class="bx bx-lock"></i>
            <input placeholder="Mot de Passe" type="password" class="input" name="pass" required="required">
          </div>
          <div class="row">
            <i class="bx bx-user"></i>
            <input type="text" class="input" name="nom" placeholder="Nom" required="required">
          </div>
          <div class="row">
            <i class="bx bx-user"></i>
            <input type="text" class="input" name="prenom" placeholder="Prénom" required="required">
          </div>
          <div class="row">
            <i class="bx bx-envelope"></i>
            <input type="email" class="input" name="email" placeholder="email" required="required">
          </div>
          <div class="row">
            <i class="bx bx-phone"></i>
            <input type="tel" class="input" name="tel" placeholder="Numéro de téléphone" required="required">
          </div>
          <div class="row">
            <i class="bx bx-home"></i>
            <input type="text" class="input" name="adresse" placeholder="Adresse" required="required">
          </div>

          <input class="btn" type="submit" value="Inscription" name="submit">
        </form>
      </div>

     
      <div class="tab-footer">
        <a class="tab-link active" data-ref="connexion" href="javascript:void(0)">Connexion</a>
        <a class="tab-link" data-ref="inscription" href="javascript:void(0)">Inscription</a>
      </div>
    </div>
    <script src="js/index.js" defer></script>
  <?php
  
  ?>
</body>

</html>