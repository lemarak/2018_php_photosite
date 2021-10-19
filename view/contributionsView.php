<?php
$title = "Contributions"
?>

<?php ob_start(); ?>

    <br/><br/><br/><br/>
    <div class="ui grid">
        <div class="three column row center aligned">
            <div class="three wide column middle aligned right aligned">
                <?php if ($page > 1) { ?>
                    <!--<div class="ui pagination menu">-->

                    <a href="contributions.php?page=<?= $page - 1 ?>" class="active item">

                        <img src="../public/images/gauche.png"/>
                    </a>
                    <!--</div>-->
                <?php } ?>
            </div>
            <div class="ten wide column">
                <h1 class="rougeFonce">Les dernières contributions</h1>

                <?php

                require('viewRess/galerieView.php');
                ?>
            </div>
            <div class="three wide column middle aligned left aligned">
                <?php if ($page < $maxPages) { ?>

                    <a href="contributions.php?page=<?= $page + 1 ?>" class="active item">
                        <img src="../public/images/droite.png"/>
                    </a>

                <?php } ?>
            </div>
        </div>
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>