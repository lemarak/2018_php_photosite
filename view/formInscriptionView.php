<br/><br/><br/><br/>
<div id="bloc">
    <h2>Formulaire d'inscription</h2>
    <?php echo '<p class="erreur">' . $message . '</p>' ?>
    <form id="form_inscr" class="ui small fluid form" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>"
          onsubmit="return verifForm(this)">
        <input type="hidden" id="modif" name="modif" value="<?= $modif; ?>"
            />

        <div class="two fields">
            <div class="field">
                <label for="nom">Nom : </label>

                <div class="ui corner labeled input">
                    <input type="text" id="nom" name="nom" placeholder="Nom" value="<?= $nom; ?>"
                           onblur="verifChamp(this,'errNom')"/>

                    <div class="ui corner label">
                        <i class="asterisk icon"></i>
                    </div>
                </div>
                <div id="errNom" class="hidden">
                </div>
            </div>
            <div class="field">
                <label for="prenom">Prénom : </label>
                <input type="text" id="prenom" name="prenom" placeholder="Prénom" value="<?= $prenom; ?>"/><br/>
            </div>
        </div>

        <div class="two fields">
            <div class="field">
                <label for="pseudo">Pseudo : </label>

                <div class="ui corner labeled input">
                    <input type="text" id="pseudo" name="pseudo" placeholder="Pseudo (entre 4 et 25 caractères)"
                           value="<?= $pseudo; ?>"
                           onblur="verifPseudo(this)"/>

                    <div class="ui corner label">
                        <i class="asterisk icon"></i>
                    </div>
                </div>
                <div id="errPseudo" class="hidden">
                </div>
            </div>
        </div>

        <div class="two fields">
            <div class="field">
                <label for="pwd">Mot de passe : </label>

                <div class="ui corner labeled input">
                    <input type="password" id="pwd" name="pwd" placeholder="Mot de passe"
                           value="<?= $modif ? $pwd : '' ?>"
                           onblur="verifChamp(this,'errPwd')"/>

                    <div class="ui corner label">
                        <i class="asterisk icon"></i>
                    </div>
                </div>
                <div id="errPwd" class="hidden">
                </div>
            </div>
            <div class="field">
                <label for="pwd2">Confirmation mot de passe : </label>

                <div class="ui corner labeled input">
                    <input type="password" id="pwd2" name="pwd2" placeholder="confirmation" onblur="verifPwd();"
                           value="<?= $modif ? $pwd : '' ?>"/>

                    <div class="ui corner label">
                        <i class="asterisk icon"></i>
                    </div>
                </div>
                <div id="errPwd2" class="hidden">
                </div>
            </div>
        </div>

        <div class="two fields">
            <div class="field">
                <label for="pwd">Email : </label>

                <div class="ui corner labeled input">
                    <input type="email" id="email" name="email" placeholder="@email" value="<?= $email; ?>"
                           onblur="verifEmail(this)"/>

                    <div class="ui corner label">
                        <i class="asterisk icon"></i>
                    </div>
                </div>
                <div id="errEmail" class="hidden">
                </div>
            </div>
        </div>

        <div class="field">
            <label for="presentation">Présentation : </label>
            <textarea name="presentation" id="presentation" rows="3" cols="45"
                      placeholder="Présentez-vous..."><?= $presentation; ?></textarea>
        </div>
        <?php
        if ( $modif != 1) {
            ?>
            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" id="cond" name="cond" />
                    <label><a href="conditions.php">J'accepte les termes et conditions</a></label>
                </div>
                <div id="errCond" class="hidden"></div>
            </div>
        <?php } ?>
        <br/>
        <div class="two fields">
            <div class="field">
                <input class="ui positive basic button" type="submit" id="submit" name="submit" value="Envoyer"/>
            </div>
            <div class="field">
                <input class="ui negative basic button" type="reset" name="reinitialiser" id="reinitialiser"
                       value="Réinitialiser"/>
            </div>
        </div>
    </form>
</div>