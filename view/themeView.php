<?php
$title = $theme
?>

<?php ob_start(); ?>

    <br/><br/><br/><br/>
    <!-- <div class="ui container center aligned">-->
    <div class="ui grid">
        <div class="three column row center aligned">
            <div class="three wide column middle aligned right aligned">
                <?php if ($page > 1) { ?>
                    <!--<div class="ui pagination menu">-->

                    <a href="theme.php?idTheme=<?= $idTheme ?>&page=<?= $page - 1 ?><?= $tri ?>" class="active item">

                        <img src="../public/images/gauche.png"/>
                    </a>
                    <!--</div>-->
                <?php } ?>
            </div>
            <div class="ten wide column">
                <h1 class="rougeFonce">Galerie <?= $theme ?></h1>
                <?php
                $for = 'theme';
                if (!$okConn) {

                    echo '<p class="erreur">Vous devez être connecté pour soumettre une critique.</p>';
                    echo '<a href="identification.php"><button class="ui grey basic button">Identification</button></a><br/><br/>';
                }
                ?>
                <div class="ui segment left aligned">
                    <div class="ui grid">
                        <div class="twelve wide column">
                            <?= $descTheme ?>
                        </div>

                        <div class="four wide column right aligned">
                            <?php if ($tri == '') { ?>
                                <a href="theme.php?idTheme=<?= $idTheme ?>&tri=note&page=<?= $page ?>"
                                   class="ui item"><i
                                        class="edit icon"></i>Trier
                                    par note</a>
                            <?php } else { ?>
                                <a href="theme.php?idTheme=<?= $idTheme ?>&page=<?= $page ?>"><i
                                        class="calendar alternate icon"></i>Trier par date</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
                require('viewRess/galerieView.php');
                ?>
                <br/>
            </div>
            <div class="three wide column middle aligned left aligned">
                <?php if ($page < $maxPages) { ?>

                    <a href="theme.php?idTheme=<?= $idTheme ?>&page=<?= $page + 1 ?><?= $tri ?>" class="active item">
                        <img src="../public/images/droite.png"/>
                    </a>

                <?php } ?>
            </div>

        </div>
    </div>
    <!--</div>-->

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>