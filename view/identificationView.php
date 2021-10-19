<?php $title = "Identification" ?>
<?php ob_start(); ?>

<div id="bloc_identification" class="ui">
    <br/><br/><br/><br/>
    <?php
    if (!$ok) {
        ?>
        <h1>Identification</h1>
        <?php if ($erreur) echo '<div class="ui error message">Echec de l\'identification</div>'; ?>
        <div class="column">
            <form class="ui large form" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                <div class="ui stacked segment">
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="text" name="pseudo" id="pseudo" placeholder="PSeudo">
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="pwd" placeholder="pwd">
                        </div>
                    </div>
                    <div class="field">
                        <input class="ui positive basic button" type="submit" name="valider" value="Valider"/>
                    </div>
                </div>

                <div class="ui error message"></div>

            </form>

            <div class="ui message">
                Nouveau membre ? <a href="inscription.php"> S'inscrire</a>
            </div>
        </div>
        <?php
    } //else header('Location: profil.php?id='.$_SESSION['id_pseudo']);
    else {
        if ($_SESSION['pseudo'] == 'admin') {
            header('location:admin.php');
        } else {
            header('location:' . $_SESSION['url_appel']);
        }
    }
    ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
