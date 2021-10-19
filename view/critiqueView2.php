<?php
$title="Vote";
?>

<?php ob_start(); ?>

    <br/><br/><br/><br/>
    <div class="ui main container">
        <h3>Critique photo</h3>
        <div class="ui grid">

            <div class="nine wide column">
                <img src="../public/photos/apercu/ap_<?=$nom ?>" alt="<?=$photo->titre()?>" title="<?=$photo->titre()?>" class="ui big rounded image" />
            </div>
            <div class="seven wide column">

                    <?php if (!$insert) { ?>
                    <!-- Formulaire -->
                    <form class="ui form" method ="POST" action="<?php $_SERVER['PHP_SELF']; ?>">

                        <div>
                            <p>La note globale est de <?=$noteFinale?></p>
                        </div>
                        </br>
                        <div class="field">
                            <textarea rows="4" name="comment"  placeholder="Impression générale..."></textarea>
                        </div>
                        <div class="field">
                            <textarea rows="4" name="conseil"  placeholder="Conseils éventuels..."></textarea>
                        </div>
                        <button class="ui button" type="submit">Envoyer</button>
                     </form>
                    <?php }
                     else { ?>
                         <div><h2>Merci d'avoir voté</h2></div>
                     <?php } ?>

            </div>
        </div>
    </div>

<?php $content=ob_get_clean(); ?>

<?php require('template.php'); ?>