<?php $title = "Photo" ?>

<?php ob_start(); ?>

<div class="ui main container" xmlns:margin-top="http://www.w3.org/1999/xhtml">
    <br/><br/><br/><br/>

    <div class="ui grid">
        <div class="row">
            <div class="two wide column"></div>
            <div class="left ten wide column">
                <h3 class="rougeFonce"><?= $titre ?>, postée par <a
                        href="profil.php?id=<?= $photo->idPSeudo() ?>"><?= $pseudo ?></a> (prise le <?= $datePrise ?>)
                </h3>
            </div>
            <div class="right two wide column"><h3><a href="theme.php?idTheme=<?= $idTheme ?>"><?= $theme ?></a></h3>
            </div>
            <div class="four wide column"></div>
        </div>
        <div class="row">
            <div class="two wide column"></div>
            <div class="twelve wide column right aligned">
                <div class="row">
                    <img src="../public/photos/apercu/ap_<?= $nom ?>" alt="<?= $titre ?>" title="<?= $titre ?>"
                         class="ui fluid image"/>
                </div>
            </div>
            <div class="two wide column"></div>
        </div>
        <div class="row">
            <div class="two wide column"></div>
            <div class="two wide column rougeFonce">
                <strong>
                    <?php
                    if ($photo->noteGlobale() != 0) {
                        echo 'note ' . $photo->noteGlobale() . ' (<i class="comment outline icon"></i>' . $nbCrit . ')';
                    } else {
                        echo '<i>pas de note</i>';
                    }
                    ?>
                </strong>
            </div>
            <div class="height wide column center aligned">
                <?php
                if (isset($_SESSION['id_pseudo']) && $_SESSION['id_pseudo'] != $photo->idPseudo()) {
                    if (!ManagerCritique::verifSiCritique($_SESSION['id_pseudo'], $photo->id())) {
                        echo '<button class="ui grey tiny button" onClick="document.location.href=\'../controler/critique.php?id_img=' . $photo->id() . '\'">Critiquer</button>';
                    }
                }
                ?>
            </div>
            <div class="one wide column"></div>
            <div class="one wide column rougeFonce"><i class="eye icon right floated "></i><?= $nbVues ?></div>
            <div class="two wide column"></div>
        </div>
        <div class="row">
            <div class="two wide column"></div>
            <div class="twelve wide column">
                <div class="ui segment left aligned">
                    <div class="ui top gray attached label">Description</div>
                    <br/>
                    <?= $description ?>
                </div>
            </div>
            <div class="two wide column"></div>
        </div>

        <div class="row">
            <div class="two wide column"></div>
            <?php if ($technique != '') { ?>
                <div class="twelve wide column">
                    <div class="ui segment left aligned">
                        <div class="ui top gray attached label">Technique</div>
                        <br/>
                        <?= $technique ?>
                    </div>
                </div>
            <?php } ?>
            <div class="two wide column"></div>
        </div>

        <div class="row">
            <div class="two wide column"></div>
            <div class="four wide column">
                <div class="ui segment left aligned">
                    <div class="ui top gray attached label">Lieu</div>
                    <br/>
                    <?= $photo->lieu() ?>
                </div>
            </div>
            <div class="four wide column">
                <div class="ui segment left aligned">
                    <div class="ui top gray attached label">Appareil</div>
                    <br/>
                    <?= $photo->camera() ?>
                </div>
            </div>
            <div class="four wide column">
                <div class="ui segment left aligned">
                    <div class="ui top gray attached label">Objectif</div>
                    <br/>
                    <?= $photo->objectif() ?>
                </div>
            </div>
            <div class="two wide column"></div>
        </div>

        <!-- <div class="ui segment"> -->
        <div class="row">
            <div class="two wide column"></div>
            <div class="twelve wide column">
                <!--<div class="ui segment">-->
                <br/>

                <h2 class="ui left floated horizontal divider header rougeFonce">
                    <strong class="rougeFonce">Critiques</strong>
                </h2>

                <h3 class="rougeFonce"><strong><?= $note ?> </strong> ( <?= $nbCrit ?> critiques)</h3>
                <table class="ui four column celled yellow table">
                    <thead>
                    <tr>
                        <th>Intention</th>
                        <th>Technique</th>
                        <th>Mise en image</th>
                        <th>Rendu global</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?= $notes[0] ?></td>
                        <td><?= $notes[1] ?></td>
                        <td><?= $notes[2] ?></td>
                        <td><?= $notes[3] ?></td>
                    </tr>
                    </tbody>
                </table>
                <!--</div>-->
            </div>
            <div class="two wide column"></div>
        </div>
        <!--</div> -->
        <div class="row">
            <div class="two wide column"></div>
            <div class="twelve wide column">

                <?php
                foreach ($critiques as $crit) {
                    $pseudoCrit = ManagerMembre::getPseudo('id', $crit->idVotant());
                    ?>
                    <div class="ui segment">
                        <!--<h4 class="ui horizontal divider header">
                            Critique de <a class="item"
                                           href="profil.php?id=<?= $crit->idVotant() ?>"><strong><?= $pseudoCrit['pseudo'] ?> </strong></a>
                        </h4>-->
                        <a class="ui orange left ribbon label" href="profil.php?id=<?= $crit->idVotant() ?>">
                            <strong><?= $pseudoCrit['pseudo'] ?> </strong></a>

                        <span style="font-size:1.0em"><strong>Note : <?= $crit->noteFinale() ?></strong></span>

                        <div class="ui basic segment left aligned">
                            <div class="ui top gray attached label">Commentaire</div>
                            <br/>
                            <?= nl2br($crit->critique()) ?>
                        </div>
                        <!--<h5 class="ui horizontal divider header">
                            Détail notes
                        </h5>-->
                        <table class="ui celled olive table t_crit">
                            <tbody>
                            <tr>
                                <td class="td_col1">Intention</td>
                                <td class="td_col2"><?= $crit->noteIntention() ?></td>
                                <td><?= nl2br($crit->comIntention()) ?></td>
                            </tr>
                            <tr>
                                <td class="td_col1">Technique</td>
                                <td class="td_col2"><?= $crit->noteTechnique() ?></td>
                                <td><?= nl2br($crit->comTechnique()) ?></td>
                            </tr>
                            <tr>
                                <td class="td_col1">Image</td>
                                <td class="td_col2"><?= $crit->noteImage() ?></td>
                                <td><?= nl2br($crit->comImage()) ?></td>
                            </tr>
                            <tr>
                                <td class="td_col1">Rendu</td>
                                <td class="td_col2"><?= $crit->noteRendu() ?></td>
                                <td><?= nl2br($crit->comRendu()) ?></td>
                            </tr>
                            </tbody>
                        </table>
                        <br/>
                    </div>
                    <?php
                }
                ?>

            </div>
            <div class="two wide column"></div>
        </div>
    </div>

</div>


<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
