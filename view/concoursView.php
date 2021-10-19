<?php
$title = $concours->nom();
?>

<?php ob_start(); ?>

    <br/><br/><br/><br/>
    <div class="ui grid">
        <div class="three column row center aligned">
            <div class="three wide column middle aligned right aligned">
                <?php
                if (!isset($_GET['resultats'])) {
                    $vote = isset($_GET['vote']) ? "&vote=1" : "";
                    ?>
                    <?php if ($page > 1) { ?>
                        <a href="concours.php?id=<?= $idConcours ?>&page=<?= $page - 1 ?><?= $vote ?>"
                           class="active item">
                            <img src="../public/images/gauche.png"/>
                        </a>
                    <?php } ?>

                <?php } ?>
            </div>
            <div class="ten wide column">
                <h1>Concours <?= $concours->nom() ?> <i> (<?= $nbPhotos ?> photos)</i></h1>

                <div class="ui segment left aligned">
                    <?= nl2br($concours->descriptif()) ?>
                </div>
                <?php
                $for = 'concours';
                if (!$okConn && isset($_GET['vote'])) {
                    echo '<p class="erreur">Vous devez être connecté pour voter.</p>';
                    echo '<a href="identification.php"><button class="ui grey basic button">Identification</button></a><br/><br/>';
                }
                if (isset($_GET['vote'])) {
                    ?>
                    <div class="ui secondary segment left aligned">
                        <h5>Merci de prendre le temps de voter.<br/>
                            Vous avez la possibilité de voter pour 3 photos (en attribuant une note de 1 à 3).<br/>
                            Vous n'avez pas la possibilite de choisir vos photos.</h5>
                    </div>
                    <?php
                }
                require('viewRess/galerieView.php');
                ?>
            </div>
            <div class="three wide column middle aligned left aligned">
                <?php
                if (!isset($_GET['resultats'])) {
                    $vote = isset($_GET['vote']) ? "&vote=1" : "";
                    ?>
                    <?php if ($page < $maxPages) { ?>
                        <a href="concours.php?id=<?= $idConcours ?>&page=<?= $page + 1 ?><?= $vote ?>"
                           class="active item">
                            <img src="../public/images/droite.png"/>
                        </a>
                    <?php } ?>

                <?php } ?>
            </div>

        </div>
    </div>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>