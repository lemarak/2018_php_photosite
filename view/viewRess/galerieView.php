<div class="ui grid">
    <?php

    $cpt = 0;
    $bResultatConcours = 0;
    //Si concours, analyse les notes déjà distribués par le votant
    //et implémente un tableau affichant ou non les boutons de vote
    if (isset($_GET['vote']) && $okConn) {
        $notes = ManagerConcours::verifSiVote($idConcours, $_SESSION['id_pseudo']);
        $butEnable1 = in_array('1', $notes) ? 'disabled' : '';
        $butEnable2 = in_array(2, $notes) ? 'disabled' : '';
        $butEnable3 = in_array(3, $notes) ? 'disabled' : '';
        if (count($notes) == 3) {
            echo '<br/><h3 class="erreur" >Vous avez déjà voté pour 3 photos</h3>';
        }
    } elseif (isset($_GET['resultats'])) {  //Pour l'affichage des résultats
        $bResultatConcours = 1;
        $notesConcours = ManagerConcours::getNotes($idConcours);
    }

    //Parcourir toutes les photos
    foreach ($photos as $p) {
    $nom = $p->nom_fichier() . '.' . $p->extension();
    $nbVues = countVues($p->id());
    $nbCrit = ManagerCritique::countCritiques('idPhoto', $p->id());
    if ($cpt % 3 == 0) {
    ?>
    <div class="three column row center aligned">
        <?php } ?>

        <div class="column">
            <div class="ui segment card hauteur">

                <div class="content">
                    <?php
                    if ($bResultatConcours == 1) {
                        echo '<div class="content">';
                        if (isset($notesConcours[$p->id()])) {
                            if ($cpt == 0) {
                                echo '<i class="star icon"></i>';
                            } elseif ($cpt == 1) {
                                echo ' <i class="star half empty icon"></i>';
                            } elseif ($cpt == 2) {
                                echo '<i class="empty star icon" ></i >';
                            }
                            echo '<strong>Note concours ' . $notesConcours[$p->id()] . '</strong><br/>';
                        }
                        echo '</div>';
                    } else {
                        echo '<div class="header">';
                        echo '<span class="left floated">';
                        if ($for == 'profil') {
                            echo $p->titre() . '<br/>';
                        } else {
                            $data2 = ManagerMembre::getPseudo('id', $p->idPseudo());
                            echo $p->titre() . ' par <a href="profil.php?id=' . $p->idPSeudo() . '"><i>' . $data2['pseudo'] . '</i></a> <br/>';
                        }
                        echo '</span>';
                        ?>
                        <span class="right floated">
                            <i class="tSize75"><?= date_format(date_create($p->date_creation()), 'd-m-Y') ?></i>
                        </span>
                        <?php
                        echo '</div>';
                    }

                    ?>
                </div>
                <div class="ui image large">
                    <a href="../controler/photo.php?id_img=<?= $p->id() ?>">
                        <img src="../public/photos/mini/mini_<?= $nom ?>" alt="<?= $p->titre() ?>"
                             title="<?= $p->titre() ?>"
                             class="ui large image"/></a>
                </div>
                <div class="content">
                    <div class="header">
                        <span class="left floated">
                        <?php if ($bResultatConcours == 1) {
                            $data2 = ManagerMembre::getPseudo('id', $p->idPseudo());
                            echo $p->titre() . ' par <a href="profil.php?id=' . $p->idPSeudo() . '"><i>' . $data2['pseudo'] . '</i></a> <br/>';
                        } else {
                            //Notes
                            if ($bResultatConcours != 1) {
                                if ($p->noteGlobale() != 0) {
                                    echo 'critique ' . $p->noteGlobale() . ' (<i class="comment outline icon"></i>' . $nbCrit . ')';
                                } else {
                                    echo '<i>pas de note</i>';
                                }
                            }
                        }
                        ?>
                        </span>
                        <span class="right floated">
                            <i class="eye icon"></i><?= $nbVues ?>
                        </span>
                    </div>

                    <div class="description">
                        <p class="aleft tSize85"><?= $p->description() ?></p>
                    </div>
                </div>
                <div class="extra content">
                    <?php //Boutons
                    if (($for == 'theme' || $for == 'contributions') && $okConn) {     //Affichage des boutons pour le thème
                        if ($_SESSION['id_pseudo'] != $p->idPseudo()) {
                            if (!ManagerCritique::verifSiCritique($_SESSION['id_pseudo'], $p->id())) {
                                echo '<button class="ui grey tiny button" onClick="document.location.href=\'../controler/critique.php?id_img=' . $p->id() . '\'">Critiquer</button>';
                            } else {
                                echo '<button class="ui grey tiny button disabled bottom aligned content">Vous avez déjà contribué</button>';
                            }
                        } else {
                            echo '<div class="bottom aligned content"><button class="ui grey tiny button disabled">Votre photo</button></div>';
                        }
                    } elseif (isset($_GET['vote']) && $okConn) {           //Affichage bouton thème
                        if ($_SESSION['id_pseudo'] != $p->idPseudo()) {
                            ?>
                            <div class="ui grey tiny buttons bottom aligned content">
                                <button class="ui button but3 <?= $butEnable3 ?>"
                                        onClick="votePhoto(<?= $idConcours ?> ,<?= $p->id() ?> ,<?= $_SESSION['id_pseudo'] ?> ,3)">
                                    <i
                                        class="star icon"></i>1er
                                </button>
                                <button class="ui button but2 <?= $butEnable2 ?>"
                                        onClick="votePhoto(<?= $idConcours ?> ,<?= $p->id() ?> ,<?= $_SESSION['id_pseudo'] ?> ,2)">
                                    <i
                                        class="star half empty icon"></i>2è
                                </button>
                                <button class="ui button but1 <?= $butEnable1 ?>"
                                        onClick="votePhoto(<?= $idConcours ?> ,<?= $p->id() ?> ,<?= $_SESSION['id_pseudo'] ?> ,1)">
                                    <i
                                        class="empty star icon"></i>3è
                                </button>
                            </div>
                        <?php } else {
                            ?>
                            <div class="bottom aligned content">
                                <button class="ui grey tiny button disabled">Votre photo</button>
                            </div>
                        <?php }
                    } elseif ($for == 'profil' && $_SESSION['id_pseudo'] == $p->idPseudo()) {  //affichage bouton profil
                        ?>
                        <div class="bottom aligned content">
                            <button class="ui grey tiny button" onclick="suppPhoto(<?= $p->id() ?>)"><i
                                    class="trash alternate icon"></i></button>
                        </div>

                    <?php } ?>

                </div>

            </div>
        </div>
        <?php
        if (($cpt + 1) % 3 == 0) {
            echo '</div>';
        }
        $cpt++;
        }
        if (($cpt) % 3 != 0) {
            echo '</div>';
        }
        if ($cpt == 0) {
            echo '<p>Pas de photos</p>';
        }
        echo '</div>';

        ?>

        <script>
            //Ajout du vote dans la bdd
            function votePhoto(idConcours, idPhoto, idVotant, note) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var res = xmlhttp.responseText;
                        if (res) {
                            var buts = document.getElementsByClassName('but' + note);
                            for (var i = 0; i < buts.length; i++) {
                                buts[i].className = "ui button disabled but" + note;
                            }
                        }
                    }
                };
                xmlhttp.open("GET", "../model/ajax.php?vote=1&idConcours=" + idConcours + "&idPhoto=" + idPhoto + "&idVotant=" + idVotant + "&note=" + note, true);
                xmlhttp.send();
            }

            //suppression photo
            function suppPhoto(id) {
                if (confirm('Supprimer la photo ?')) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var res = xmlhttp.responseText;
                            if (res) {
                                alert('Suppression OK');
                                window.location.reload();
                            }
                        }
                    };
                    xmlhttp.open("GET", "../model/ajaxAdmin.php?photo=" + id, true);
                    xmlhttp.send();
                }
            }
        </script>
