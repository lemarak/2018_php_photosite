<?php
$title = 'Page admin';
?>

<?php ob_start(); ?>
<br/><br/><br/><br/>
<div class="ui grid">
    <div class="one wide column center aligned"></div>

    <div class="fourteen wide column">
        <div class="row center aligned"><h2>Administration du site</h2></div>

        <!--********* Membres **************-->
        <div class="ui orange segment">
            <h3>Administration des membres</h3>
            <table class="ui selectable celled table">
                <thead>
                <tr>
                    <th>Pseudo</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Mail</th>
                    <th class="center aligned">Nb photos</th>
                    <th class="center aligned">Nb critiques</th>
                    <th class="center aligned">Suppression</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $cpt = 1;
                foreach ($membres as $membre) {
                    $nbPhotos = ManagerPhoto::countPhoto('idPseudo', $membre->id());
                    $nbCritiques = ManagerCritique::countCritiques('idVotant', $membre->id());
                    ?>
                    <tr id="tr_<?= $cpt ?>">
                        <td><a href="profil.php?id=<?= $membre->id() ?>"><?= $membre->pseudo() ?></a></td>
                        <td><?= $membre->nom() ?></td>
                        <td><?= $membre->prenom() ?></td>
                        <td><?= $membre->email() ?></td>
                        <td class="center aligned"><?= $nbPhotos ?></td>
                        <td class="center aligned"><?= $nbCritiques ?></td>
                        <td class="center aligned">
                            <button id="bt_<?= $cpt ?>" class="ui button"
                                    onclick="suppMembre(<?= $membre->id() ?>,<?= $cpt ?>,'<?= $membre->pseudo() ?>')"><i
                                    class="trash alternate icon"></i></button>
                        </td>
                    </tr>
                    <?php
                    $cpt++;
                } ?>
                </tbody>
            </table>
        </div>


        <!--********* Photos **************-->
        <div class="ui yellow segment">
            <h3>Administration des photos</h3>
            <?php
            $cpt = 0;
            foreach ($themesPhotos as $idTheme => $tp) { //debut grille thème
                $libTheme = getThemes($idTheme);
                ?>
                <h4><?= $libTheme ?></h4>

                <div class="ui stackable grid">
                    <?php
                    foreach ($tp as $p) {       //debut photos
                        $nom = $p->nom_fichier() . '.' . $p->extension();
                        ?>
                        <div id="ph_<?= $cpt ?>" class="two wide column center aligned">
                            <a href="../controler/photo.php?id_img=<?= $p->id() ?>">
                                <img src="../public/photos/mini/mini_<?= $nom ?>" alt="<?= $p->titre() ?>"
                                     title="<?= $p->titre() ?>" class="ui large rounded image"/></a><br/>
                            <button id="btp_<?= $cpt ?>" class="ui button tiny"
                                    onclick="suppPhoto(<?= $p->id() ?>,<?= $cpt ?>)"><i
                                    class="trash alternate icon"></i></button>
                        </div>
                        <?php $cpt++;
                    }                     //fin photo ?>
                </div>
                <br/>
                <div class="ui divider"></div>
                <?php
            }                       //fin grille thème

            ?>

        </div>


        <!--********* Concours **************-->
        <div class="ui olive segment">
            <h3>Administration des concours</h3>

            <?php
            $cpt = 1;
            foreach ($concours as $c) {
                ?>
                <form name="conc_<?= $cpt ?>" id="conc_<?= $cpt ?>" method="post" action="" class="ui small form">
                    <div class="field">
                        <input type="hidden" name="id_<?= $cpt ?>" id="id_<?= $cpt ?>" value="<?= $c->id() ?>"/>
                    </div>
                    <div class="fields">
                        <div class="two wide field">
                            <label>Titre</label>
                            <input type="text" id="nom_<?= $cpt ?>" value="<?= $c->nom() ?>"/>
                        </div>
                        <div class="four wide field">
                            <label>Thème</label>
                            <input type="text" id="theme_<?= $cpt ?>" value="<?= $c->theme() ?>"/>
                        </div>
                        <div class="ten wide field">
                            <label>Description</label>
                            <textarea id="desc_<?= $cpt ?>" rows="3"><?= $c->descriptif() ?></textarea>
                        </div>
                        <div class="two wide field">
                            <label>Actif vote</label>
                            <input type="checkbox" tabindex="0" id="actif_<?= $cpt ?>" name="actif_<?= $cpt ?>"
                                   <?= $c->actifVote()==1?'checked':'' ?>/>

                        </div>
                    </div>
                    <div class="fields">
                        <div class="two wide field">
                            <label>Date début</label>
                            <input type="date" id="dateDebut_<?= $cpt ?>" value="<?= $c->dateDebut() ?>"/>
                        </div>
                        <div class="two wide field">
                            <label>Date fin</label>
                            <input type="date" id="dateFin_<?= $cpt ?>" value="<?= $c->dateFin() ?>"/>
                        </div>
                        <div class="two wide field">
                            <label>Date début vote</label>
                            <input type="date" id="dateDebutVote_<?= $cpt ?>" value="<?= $c->dateDebutVote() ?>"/>
                        </div>
                        <div class="two wide field">
                            <label>Date fin vote</label>
                            <input type="date" id="dateFinVote_<?= $cpt ?>" value="<?= $c->dateFinVote() ?>"/>
                        </div>

                    </div>
                    <div class="two wide field">
                        <div class="ui button" onclick="modifConcours(<?= $c->id() ?>,<?= $cpt ?>)">Modifier</div>
                    </div>
                </form>
                <div class="ui divider"></div>
                <?php $cpt++;
            } ?>
        </div>

    </div>
    <div class="one wide column"></div>
</div>


<!-- ******   AJAX  ****** -->
<script>
    //suppression Membre
    function suppMembre(id, cpt, pseudo) {
        if (confirm('Supprimer ' + pseudo + ' ?')) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var res = xmlhttp.responseText;
                    if (res) {
                        var tr = document.getElementById('tr_' + cpt);
                        tr.parentNode.removeChild(tr);
                        alert('Suppression OK');
                    }
                }
            };
            xmlhttp.open("GET", "../model/ajaxAdmin.php?membre=" + id, true);
            xmlhttp.send();
        }
    }

    function suppPhoto(id, cpt) {
        if (confirm('Supprimer la photo ?')) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var res = xmlhttp.responseText;
                    if (res) {
                        var ph = document.getElementById('ph_' + cpt);
                        ph.parentNode.removeChild(ph);
                        alert('Suppression OK');
                    }
                }
            };
            xmlhttp.open("GET", "../model/ajaxAdmin.php?photo=" + id, true);
            xmlhttp.send();
        }
    }

    function modifConcours(id, cpt) {
        var nom = document.getElementById('nom_' + cpt).value;
        var theme = document.getElementById('theme_' + cpt).value;
        var descriptif = document.getElementById('desc_' + cpt).value;
        var dateDebut = document.getElementById('dateDebut_' + cpt).value;
        var dateFin = document.getElementById('dateFin_' + cpt).value;
        var dateDebutVote = document.getElementById('dateDebutVote_' + cpt).value;
        var dateFinVote = document.getElementById('dateFinVote_' + cpt).value;
        var actifVote = document.getElementById('actif_' + cpt).checked;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var res = xmlhttp.responseText;
                if (res===true) {
                    alert('Modification OK');
                }
            }
        };
        xmlhttp.open("POST", "../model/ajaxAdmin.php?concours=" + id, true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xmlhttp.send("id=" + id + "&nom=" + nom + "&theme=" + theme + "&descriptif=" + descriptif + "&dateDebut=" + dateDebut +
            "&dateFin=" + dateFin + "&dateDebutVote=" + dateDebutVote + "&dateFinVote=" + dateFinVote + "&actifVote=" + actifVote);
    }
</script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
