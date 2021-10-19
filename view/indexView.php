<?php $title = "Accueil" ?>

<?php ob_start(); ?>


    <br/><br/><br/><br/>


    <div class="ui main container">
        <h2>Bienvenue sur PHOTOSITE, ici vous pouvez...</h2>

        <div class="ui segment row center aligned">
            <h2>Visualiser les photos déposées par les membres</h2>
            <a href="contributions.php" class="ui big image">
                <img src="../public/images/imgCritiques.png">
            </a>
        </div>
        <div class="ui segment row center aligned">
            <h2>Proposer une critique constructive</h2>
            <a href="contributions.php" class="ui huge image">
                <img src="../public/images/imgCritique.PNG">
            </a>
        </div>
        <div class="ui segment row center aligned">
            <h2>Participer et voter à des concours</h2>
            <a href="concours.php?id=1&vote=1" class="ui huge image">
                <img src="../public/images/imgVotes.PNG">
            </a>
        </div>

    </div>

<?php $content = ob_get_clean(); ?>

<?php require('templateHome.php'); ?>