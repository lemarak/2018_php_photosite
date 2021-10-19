<?php
$title = "Les concours";
?>

<?php ob_start(); ?>

    <br/><br/><br/><br/>
    <div class="ui container">
        <h1>Concours archivés</h1>

        <div class="ui grid">
            <?php foreach ($concours as $c) {
                $notesConcours = ManagerConcours::getNotes($c->id()); ?>
                <div class="row">
                    <h3><a href="concours.php?id=<?=$c->id()?>&resultats=1"> <?= $c->nom() ?></a> <i>(<?= date_format(date_create($c->dateDebut()), 'd-m-Y') ?>)</i></h3>
                </div>
                <div class="row">
                    <?= $c->descriptif() ?>
                </div>
                <div class="three column row center aligned">
                    <?php foreach ($photoConcours[$c->id()] as $p) {
                        $nom = $p->nom_fichier() . '.' . $p->extension();
                        $pseudo = ManagerMembre::getPseudo('id', $p->idPseudo());
                        $note = $notesConcours[$p->id()];
                        ?>
                        <div class="column">
                            <div class="ui segment">
                                <?=$p->titre()?> par <?=$pseudo['pseudo']?><br/>
                                Note : <?=$note?>
                                <img src="../public/photos/mini/mini_<?= $nom ?>" alt="<?= $p->titre() ?>"
                                     title="<?= $p->titre() ?>"
                                     class="ui miny rounded image"/>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>