<?php
$title = "Vote";
?>

<?php ob_start(); ?>

    <br/><br/><br/><br/>
    <div class="ui main container">
        <h3>Critique photo</h3>

        <div class="ui secondary segment">
            <p>Merci de prendre le temps de critiquer cette photo<br/>
                La critique doit être constructive, vous pouvez argumenter chaque note que vous attribuez.</p>
        </div>
        <div class="ui grid">

            <div class="nine wide column">
                <img src="../public/photos/apercu/ap_<?= $nom ?>" alt="<?= $photo->titre() ?>"
                     title="<?= $photo->titre() ?>" class="ui big rounded image"/>
            </div>
            <div class="seven wide column">

                <!-- Formulaire -->

                <form class="ui form" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                    <?php
                    if ($error != '') {
                        echo '<h4 class="erreur">' . $error . '</h4>';
                    }
                    $n = 0;
                    foreach ($tabCrit as $crit) { ?>
                        <div class="inline fields">
                            <label for="tabNote[<?= $n ?>]"></label><?= $crit ?></label>
                            <?php echo '&nbsp';
                            for ($i = 1; $i <= 5; $i++) { ?>
                                <div class="field">
                                    <div class="ui radio checkbox">
                                        <input type="radio" name="tabNote[<?= $n ?>]"
                                               value="<?= $i ?>" <?= isset($tabNotes[$n]) && $tabNotes[$n] == $i ? 'checked' : '' ?>>
                                        <label><?= $i ?></label>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="field">
                            <textarea rows="2" name="tabComment[<?= $n ?>]"
                                      placeholder="<?= $tabComments[$n] == '' ? $tabCritComment[$n] : '' ?>"><?= $tabComments[$n] ?></textarea>
                        </div>
                        <?php
                        $n++;
                    } ?>
                    <button class="ui button" type="submit">Etape 1/2</button>
                </form>
                <!-- // formulaire 1/2 -->


            </div>
        </div>
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>