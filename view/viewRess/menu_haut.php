<!-- Barre de menu Haut -->
<div class="ui fixed inverted grey menu">
    <div class="ui container">
        <a href="index.php" class="header item">
            <img class="logo" src="../public/images/logo.png" alt="logo">

            <p> PhotoSite</p>
        </a>

        <!-- Critiques -->
        <div class="ui simple dropdown item">
            Critiques <i class="dropdown icon"></i>

            <div class="menu">
                <a class="item" href="depot.php?for=critique">Soumettre une photo</a>
                <a class="item" href="contributions.php">Contributions récentes</a>

                <div class="divider"></div>
                <div class="header">Thèmes</div>
                <?php
                /* Affichage des thèmes */
                $reqMenu = getThemes(0);

                while ($dataMenu = $reqMenu->fetch()) {
                    echo '<a class="item" href="theme.php?idTheme=' . $dataMenu['id'] . '">' . $dataMenu['libelleTheme'] . '</a>';
                }
                $reqMenu->closeCursor();
                ?>
            </div>
        </div>

        <!-- Concours -->
        <div class="ui simple dropdown item">
            Concours <i class="dropdown icon"></i>

            <div class="menu">
                <div class="header">Concours la ville</div>
                <a class="item" href="depot.php?for=concours&id=4">participer</a>
                <a class="item" href="concours.php?id=4">Galerie</a>

                <div class="divider"></div>
                <div class="header">Concours Paysage (ouvert au vote)</div>
                <a class="item" href="concours.php?id=5&vote=1">Voter</a>
                <a class="item" href="concours.php?id=5&resultats=1">Résultats</a>

                <div class="divider"></div>
                <a class="item" href="listeConcours.php">Archive concours</a>
            </div>
        </div>
        <div class="right menu">
            <?php if ($okConn) { ?>

                <!-- Forum Faq -->
                <a href="#" class="item">Forum</a>

                <!-- Page perso -->
                <?php if ($_SESSION['pseudo'] == 'admin') {
                    ?>
                    <a href="admin.php"
                       class="item"><i><?php echo $_SESSION['pseudo']; ?></i></a>
                    <?php
                } else {
                    ?>
                    <a href="profil.php?id=<?= $_SESSION['id_pseudo'] ?>"
                       class="item"><i><?php echo $_SESSION['pseudo']; ?></i></a>
                <?php } ?>
                <!-- Page deconnexion -->
                <a href="deconnexion.php" class="item">Déconnexion</a>
            <?php } else { ?>
                <!-- Inscription -->
                <div class="ui inverted grey segment">
                    <a href="inscription.php" class="small ui inverted button">Inscription</a>

                    <!-- Identification -->
                    <a href="identification.php" class="small ui inverted button">Identification</a>
                </div>
            <?php } ?>
        </div>


    </div>
</div>

