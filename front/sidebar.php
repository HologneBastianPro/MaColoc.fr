<div class="sidebar close">
  <div class="logo-details">
    <i class='bx bx-home-smile'></i>
    <span class="logo_name">MaColoc.fr</span>
  </div>
  <ul class="nav-links">
    <li>
      <a href="Liste_Colocs.php">
        <i class='bx bx-grid-alt'></i>
        <span class="link_name">Liste Colocs</span>
      </a>
      <ul class="sub-menu blank">
        <li><a class="link_name" href="Liste_Colocs.php">Liste Colocs</a></li>
      </ul>
    </li>
    <li>
      <div class="iocn-link">
        <a href="Ma_Coloc.php">
          <i class='bx bx-home-heart'></i>
          <span class="link_name">Ma Coloc</span>
        </a>
        <i class='bx bxs-chevron-down arrow'></i>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name" href="Ma_Coloc.php">Ma Coloc</a></li>
        <?php
          if ($_SESSION['role'] == 'Gerant coloc') {
            ?>
              <li><a href="Ma_Coloc.php#generale">Infos générales</a></li>
              <li><a href="Ma_Coloc.php#cagnotte">Infos cagnotte</a></li>
              <li><a href="Ma_Coloc.php#apport">Les apports</a></li>
              <li><a href="Ma_Coloc.php#achat">Les achats</a></li>
              <li><a href="Ma_Coloc.php#gestionColoc">Gestion coloc</a></li>
            <?php
          } elseif ($_SESSION['role'] == 'Membre coloc'){
            ?>
              <li><a href="Ma_Coloc.php#generale">Infos générales</a></li>
              <li><a href="Ma_Coloc.php#cagnotte">Infos cagnotte</a></li>
              <li><a href="Ma_Coloc.php#apport">Les apports</a></li>
              <li><a href="Ma_Coloc.php#achat">Les achats</a></li>
            <?php
          }
        ?>
      </ul>
    </li>
    <li>
      <div class="iocn-link">
        <a href="info_perso.php">
          <i class='bx bx-cog'></i>
          <span class="link_name">Infos Personnelles</span>
        </a>
        <i class='bx bxs-chevron-down arrow'></i>
        </div>
        <ul class="sub-menu">
          <?php
            if ($_SESSION['role'] == 'Sans coloc') {
              ?>
                <li><a class="link_name" href="info_perso.php">Infos Personnelles</a></li>
                <li><a href="info_perso.php#generale">Infos personnelles</a></li>
                <li><a href="info_perso.php#versement">Mes versements</a></li>
                <li><a href="info_perso.php#change">Rejoindre une coloc</a></li>
              <?php
            } else {
              ?>
                <li><a class="link_name" href="info_perso.php">Infos Personnelles</a></li>
                <li><a href="info_perso.php#generale">Infos personnelles</a></li>
                <li><a href="info_perso.php#versement">Mes versements</a></li>
                <li><a href="info_perso.php#change">Changer de coloc</a></li>
                <li><a href="info_perso.php#coloc">Quitter coloc</a></li>
              <?php
            }
          ?>
        </ul>
    </li>
    <li>
      <div class="profile-details">
        <div class="profile-content">
        </div>
        <div class="name-job">
          <div class="profile_name">
            <?php
            echo $_SESSION['username'];
            ?>
          </div>
          <div class="job"><?php echo $_SESSION['role'] ?></div>
        </div>
        <a href="logout.php">
          <i class='bx bx-log-out'></i>
        </a>
      </div>
    </li>
  </ul>
</div>