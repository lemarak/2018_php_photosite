<?php $title = "Soumettre une photo" ?>

<?php ob_start(); ?>

    <br/><br/><br/><br/>
    <div id="bloc">

        <?php if ($_GET['for'] == "concours" && $okConn) { ?>
            <h1>Participer au concours <i><?= $concours->nom() ?></i></h1>
            <?php
        } else {
            ?>
            <h1>Déposer une photo <?php echo '(' . $_GET['for'] . ')'; ?></h1>
        <?php } ?>
        <?php
        $nbOK=true;
        if (!$okConn) {
            echo '<p class="erreur">Vous devez être connecté pour déposer une photo.</p>';
            echo '<a href="identification.php"><button class="ui grey basic button">Identification</button></a><br/><br/>';
        } else {

            if ($_GET['for'] == "concours") { //pour concours
                ?>
                <p>La limite des contributions pour un concours est de <?= $nbMax ?> photos.</p>
                <?php
                if ($nbParticipations >= $nbMax) {
                    $nbOK = false;
                    ?>
                    <p class="erreur">Vous avez dépassé la limite...(<?= $nbParticipations ?> participation(s) )</p>

                    <?php
                }
            }

            //else {
            if ($_GET['for'] == 'concours' && $nbOK) {
                echo '<h2>Vous pouvez déposer une photo... </h2>';
            }
            if (!isset($_FILES['photo']) && !isset($_POST['titre']) && $nbOK) {
                affiche_form(1);
                //miniGalerie pour dépot concours
                if ($_GET['for'] == 'concours' && $nbParticipations < $nbMax) {
                    $photosMini = ManagerPhoto::getGalerie('idPseudo', $_SESSION['id_pseudo']);
                    $vote = true;
                    echo '<br/><br/>';
                    echo '<div class="ui divider"></div>';
                    echo '<h2>... ou sélectionner une photo de votre galerie</h2>';
                    require('viewRess/miniGalerieView.php');
                }
            } elseif (isset($_FILES['photo']) && !isset($_POST['titre']) && $nbOK) {
                $ok = uploadPhoto();

                if ($ok) {
                    affiche_form(2);
                }
            } elseif ($nbOK) {
                traitement_photo();
            }


            //}
        }
        ?>
    </div>


<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>