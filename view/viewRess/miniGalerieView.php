<?php

/*if ($for==='profil') {
   $photos=ManagerPhoto::getGalerie('idPseudo',$_GET['id']);
   //$req = getGalerie('idPseudo',$_SESSION['id_pseudo']);
}
elseif ($for==='theme') {
   $photos=ManagerPhoto::getGalerie('idTheme',$idTheme,$page);
   //$req = getGalerie('idTheme',$idTheme);
}*/
echo '<div id="galerie" class="ui grid">';

$cpt = 0;
foreach ($photosMini as $p) {
    if ($cpt % 6 == 0) {
        echo '<div class="six column row center aligned">';
    }
    $nom = $p->nom_fichier() . '.' . $p->extension();
    echo '<div class="column">';

    echo '<p>' . $p->titre() . '<br/>';

    if ($p->noteGlobale() != 0) {
        echo 'Note ' . $p->noteGlobale() . '<br/>';
    } else {
        echo ' -- <br/>';
    }
    echo date_format(date_create($p->date_creation()), 'd-m-Y') . '</p>';
    echo '<a href="../controler/photo.php?id_img=' . $p->id() . '">';
    echo '<img src="../public/photos/mini/mini_' . $nom . '" alt="' . $p->titre() . '" title="' . $p->titre() . '" class="ui large rounded image" /></a>';
    echo '<p class="aleft tSize85">' . $p->description() . '</p>';
    if (isset($vote) && $vote) {       //Affichage des boutons pour choix concours
        if (!ManagerConcours::verifDepotConcours($_GET['id'], $p->id())) {
            echo '<button id="choix[' . $p->id() . ']" class="ui icon button" onClick="choixPhoto(' . $_GET['id'] . ',' . $p->id() . ')"><i class="trophy icon"></i></button>';
        } else {
            echo '<button id="choix[' . $p->id() . ']" class="ui icon button disabled"><i class="trophy icon"></i></button>';
        }
    }
    echo '</div>';
    if (($cpt + 1) % 6 == 0) {
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
</div>
<script>
    //Pour insérer photo dans concours
    function choixPhoto(idConcours, idPhoto) {
        var nbMax = 6;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var res = xmlhttp.responseText;
                if (res > 0 && res < nbMax) {
                    var but = document.getElementById("choix[" + idPhoto + "]");
                    but.innerHTML = "<i class=\"check circle outline icon\"></i>";
                }
                else if (res >= nbMax) {
                    alert('Vous venez d\'atteindre la limite disponible de dépot pour ce concours.');
                    var gal = document.getElementById('galerie');
                    var buts = gal.getElementsByTagName("button");
                    for (var i = 0; i < buts.length; i++) {
                        buts[i].className = "ui icon button disabled";
                    }
                }
                else if (res == 0) {
                    alert('L\'ajout de la photo a échoué !!!');
                }
            }
        };
        xmlhttp.open("GET", "../model/ajax.php?idConcours=" + idConcours + "&idPhoto=" + idPhoto, true);
        xmlhttp.send();

    }
</script>
