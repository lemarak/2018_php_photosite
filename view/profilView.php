<?php
$title = "Profil";
?>

<?php ob_start(); ?>

    <br/><br/><br/><br/>
    <div class="ui main container">

        <?php
        $for = 'profil';
        ?>

        <div class="ui teal segment">

            <h2 class="rougeFonce">Profil de <?= $membre->pseudo() ?></h2>

            <div class="ui grid">

                <div class="height wide column">
                    <div class="ui basic segment left aligned">
                        <div class="ui horizontal label"><h4>Nom</h4></div>
                        <strong><?= nl2br($membre->nom()) ?></strong>
                    </div>
                </div>

                <div class="height wide column">
                    <div class="ui basic segment left aligned">
                        <div class="ui horizontal label"><h4>Prénom</h4></div>
                        <strong><?= nl2br($membre->prenom()) ?></strong>
                    </div>
                </div>

                <div class="height wide column">
                    <div class="ui basic segment left aligned">
                        <div class="ui horizontal label"><h4>Photos déposées</h4></div>
                        <strong><?= ManagerPhoto::countPhoto('idPseudo', $membre->id()) ?></strong>
                    </div>
                </div>
                <div class="height wide column">
                    <div class="ui basic segment left aligned">
                        <div class="ui horizontal label"><h4>Critiques déposées</h4></div>
                        <strong><?= ManagerCritique::countCritiques('idVotant', $membre->id()) ?></strong>
                    </div>
                </div>

                <div class="sixteen wide column">
                    <div class="ui basic segment left aligned">
                        <div class="ui horizontal gray label"><h4>Présentation</h4></div>
                        <strong><?= nl2br($membre->presentation()) ?></strong>
                    </div>
                </div>

                <?php if ($modif) { ?>
                    <div class="sixteen wide column center aligned">
                        <a href="inscription.php?modif=1&id=<?= $membre->id() ?>">
                            <button class="ui grey basic button">Modification de la fiche</button>
                        </a><br/>
                    </div>
                <?php } ?>
            </div>

        </div>
        <br/>

        <div class="ui olive segment">
            <h2 class="rougeFonce">Galerie perso</h2>
            <?php
            require('viewRess/galerieView.php');
            ?>
        </div>
        <br/><br/>

        <div class="ui orange segment">
            <h2 class="rougeFonce">Critiques déposées</h2>
            <?php
            $photosMini = [];
            foreach ($critiques as $critique) {

                $photosMini[] = ManagerPhoto::getPhoto($critique->idPhoto());

            }
            require('viewRess/miniGalerieView.php');
            ?>
        </div>
    </div>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>