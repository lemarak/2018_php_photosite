<!-- Formulaire HTML -->
<?php
$tab_theme = getListeThemes(); //lecture des thèmes
?>

<?php //Etape 1 : téléchargement de l'image
if ($etape == 1) {
    ?>
    <div class="ui segment left aligned">
        <h5>La photo doit être au format png/jpg/jpeg et de taille inférieure à 20 Mo.</h5>
    </div>
    <form id="form_photo" class="ui small form" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>"
          enctype="multipart/form-data"> <!--onsubmit="return verifForm(this)"-->
        <div class="field">
            <label for="photo">Choisir une photo</label>
            <input class="ui basic button" type="file" name="photo" id="photo"/><br/>
        </div>
        <!--<div class="two fields">-->
        <div class="field">
            <input class="ui positive basic button" type="submit" id="submit" name="submit" value="Envoyer" onclick="envoie()"/>
        </div>
        <!--</div>-->
    </form>
    <?php
} elseif ($etape == 2) {  //Etape 2 : données de la photo
    ?>
    <img src="../public/photos/apercu/ap_<?= $_SESSION['nomPhoto'] . '.' . $_SESSION['exPhoto'] ?>"
         alt="image"
         title="image" class="ui large rounded image"/>
    <form id="form_depot" class="ui small fluid form" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>"
          onsubmit="return verifForm(this)">
        <div class="two fields">
            <div class="field">
                <label for="titre">Titre </label>

                <div class="ui corner labeled input">
                    <input type="text" id="titre" name="titre" placeholder="Titre" value="<?php /*echo $titre;*/ ?>"
                           onblur="verifChamp(this,'errTitre')"/>

                    <div class="ui corner label">
                        <i class="asterisk icon"></i>
                    </div>
                </div>
                <div id="errTitre" class="hidden">
                </div>
            </div>
        </div>

        <div class="two fields">
            <div class="field">
                <label for="theme">Thème </label>
                <select class="ui dropdown" name="theme" id="theme">
                    <?php
                    foreach ($tab_theme as $cle => $element) {
                        echo '<option value="' . $cle . '">' . $element . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="two fields">
            <div class="field">
                <label for="lieu">Lieu </label>

                <div class="ui corner labeled input">
                    <input type="text" id="lieu" name="lieu" placeholder="Lieu" value="<?php /*echo $lieu;*/ ?>"
                           onblur="verifChamp(this,'errLieu')"/>

                    <div class="ui corner label">
                        <i class="asterisk icon"></i>
                    </div>
                </div>
                <div id="errLieu" class="hidden">
                </div>
            </div>
            <div class="field">
                <label for="datePrise">Date de prise </label>
                <input type="date" id="datePrise" name="datePrise" value="<?php /*echo $datePrise;*/ ?>"/><br/>
            </div>
        </div>

        <div class="two fields">
            <div class="field">
                <label for="camera">Appareil photo </label>
                <input type="text" id="camera" name="camera" placeholder="Appareil photo"
                       value="<?php /*echo $camera;*/ ?>"/>
            </div>
            <div class="field">
                <label for="objectif">Objectif/Zoom </label>
                <input type="text" id="objectif" name="objectif" placeholder="Objectif"
                       value="<?php /*echo $objectif;*/ ?>"/>
            </div>
        </div>

        <div class="field">
            <label for="description">Notes, contexte </label>

            <div class="ui corner labeled input">
               <textarea name="description" id="description" rows="5" cols="45" placeholder="  Un petit mot..."
                         onblur="verifChamp(this,'errDescription')"></textarea>

                <div class="ui corner label">
                    <i class="asterisk icon"></i>
                </div>
            </div>
            <div id="errDescription" class="hidden">
            </div>
        </div>

        <div class="field">
            <label for="technique">Infos techniques </label>

            <textarea name="technique" id="technique" rows="5" cols="45"
                      placeholder="Infos techniques..."></textarea></span><br/>
        </div>

        <div class="two fields">
            <div class="field">
                <input class="ui negative basic button" type="reset" name="reinitialiser" id="reinitialiser"
                       value="Réinitialiser"/>
            </div>
            <div class="field">
                <input class="ui positive basic button" type="submit" id="submit" name="submit" value="Envoyer"/>
            </div>
        </div>
    </form>

    <?php
}
?>