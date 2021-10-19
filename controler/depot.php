<?php
session_start();
require_once('../model/model.php');
require_once('../model/Photo.php');
require_once('../model/ManagerPhoto.php');
require_once('../model/Concours.php');
require_once('../model/ManagerConcours.php');
require_once('../model/ress_php.php');
$okConn = verif_login();

?>

<?php

$nbMax = 6;
if ($_GET['for'] == 'concours' && $okConn) {
    $concours = ManagerConcours::getConcours($_GET['id']);
    $nbParticipations = ManagerConcours::getParticipationConcours($concours->id(), $_SESSION['id_pseudo']);

}
function affiche_form($etape)
{ /*Affiche le formulaire
                               $bRetour si retour aprés échec, permet d'afficher les valeurs saisies*/

    if ($etape == 2) {
        /* $titre=htmlspecialchars($_POST['titre']);
         $description=htmlspecialchars($_POST['description']);
         $technique=htmlspecialchars($_POST['technique']);
         $camera=htmlspecialchars($_POST['camera']);
         $objectif=htmlspecialchars($_POST['objectif']);
         $lieu=htmlspecialchars($_POST['lieu']);
         $datePrise=htmlspecialchars($_POST['date']);*/
    } else {
        $titre = '';
        $description = '';
        $technique = '';
        $camera = '';
        $objectif = '';
        $lieu = '';
        $datePrise = '';
    }

    require('../view/formDepotView.php');
}

function uploadPhoto()
{
    $bOK = true;

    try {
        if (!is_uploaded_file($_FILES['photo']['tmp_name'])) {
            echo $_FILES['photo']['tmp_name'];
            throw new Exception('Un problème est survenu durant l\'opération. Veuillez réessayer !');
        } elseif (!isset($_FILES['photo'])) {
            throw new Exception("Pas de photo");
        } else { // Tests sur fichier photo
            $extensions = array('png', 'jpg', 'jpeg');
            $extension = strtolower(substr(strrchr($_FILES['photo']['name'], '.'), 1));
            if (!in_array($extension, $extensions)) {   //verif extension
                throw new Exception('Vous devez uploader un fichier de type png, gif, jpg, jpeg.');
            }
            define('MAXSIZE', 20000000);
            if ($_FILES['photo']['size'] > MAXSIZE) {   //verif taille
                throw new Exception('Votre image est supérieure à la taille maximale de ' . MAXSIZE . ' octets');
            }
            if ($bOK) {
                //$uploaddir = $_SERVER["DOCUMENT_ROOT"] . '/public/photos/';
                $uploaddir = dirname(__DIR__, 1) . '/public/photos/';
                $name = uniqid();
                //$uploadfile = $uploaddir . $_FILES["photo"]["name"];
                //$uploadfile = $uploaddir . strtr($name, '/', '') . '.' . strtr($extension, '/', '');

                //Transfert
                //if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
                //$bOK = true;
                //} else {
                //    throw new Exception ('Problème au téléchargement de la photo');
                //}
            }
        }
    } catch (exception $e) {
        $strMessage = $e->getMessage();
        require('../view/viewRess/errorView.php');
        affiche_form(1);
        $bOK = false;
    }
    if ($bOK) {
        creer_miniature($_FILES['photo']['tmp_name'], $name, $extension, 300, "../public/photos/mini/mini_");
        creer_miniature($_FILES['photo']['tmp_name'], $name, $extension, 900, "../public/photos/apercu/ap_");
        $_SESSION['nomPhoto'] = $name;
        $_SESSION['exPhoto'] = $extension;
        $etape = 2;
    }
    return $bOK;
}

function traitement_photo()
{

    try {
        if (!isset($_POST['datePrise']) || $_POST['datePrise'] == '') {
            $datePrise = '1970-01-01';
        } else {
            $datePrise = htmlspecialchars($_POST['datePrise']);
        }
        $photo = new Photo([
            'id' => 0,
            'titre' => htmlspecialchars($_POST['titre']),
            'nom_fichier' => $_SESSION['nomPhoto'],
            'extension' => $_SESSION['exPhoto'],
            'lieu' => htmlspecialchars($_POST['lieu']),
            'datePrise' => $datePrise,
            'description' => htmlspecialchars($_POST['description']),
            'technique' => htmlspecialchars($_POST['technique']),
            'camera' => htmlspecialchars($_POST['camera']),
            'objectif' => htmlspecialchars($_POST['objectif']),
            'idPseudo' => $_SESSION['id_pseudo'],
            'idTheme' => $_POST['theme'],
            'noteGlobale' => 0,
            'date_creation' => ''
        ]);

        $lastIdPhoto = ManagerPhoto::insertPhoto($photo);

        if (!$lastIdPhoto) {
            //throw new Exception('Impossible d\'ajouter la photo ' . $okAjoutPhoto . $name . $extension);
            throw new Exception($lastIdPhoto . $photo->nom_fichier() . $photo->extension());
        } else {
            if ($_GET['for'] == 'concours') {
                if (ManagerConcours::insertParticipation($_GET['id'], $lastIdPhoto)) {
                    echo '<script>alert("Merci de votre participation")</script>';
                }

            } else {
                echo '<script>alert("La photo a bien été téléchargée.")</script>';
                header('location:http:theme.php?idTheme=' . $_POST['theme']);
            }
        }
    } catch (exception $e) {
        $strMessage = $e->getMessage();
        require('../view/viewRess/errorView.php');
    }
}

?>

<?php require('../view/depotView.php'); ?>

<script>
    function surligne(champ, erreur) {
        if (erreur)
            champ.parentElement.className = "ui corner labeled input error";
        //champ.style.backgroundColor = "#fba";
        else
            champ.parentElement.className = "ui corner labeled input";
        //champ.style.backgroundColor = "#fff";
    }

    function verifChamp(champ, id) {
        if (champ.value == '') {
            surligne(champ, true);
            document.getElementById(id).className = "ui pointing red basic label";
            document.getElementById(id).innerHTML = "saisie obligatoire";
            return false;
        }
        else {
            surligne(champ, false);
            document.getElementById(id).className = "hidden";
            document.getElementById(id).innerHTML = "";
            return true;
        }
    }

    function verifForm(f) {
        $okTitre = verifChamp(f.titre, 'errTitre');
        $okDescription = verifChamp(f.description, 'errDescription');
        $okFile = true;

        if ($okTitre && $okDescription && $okFile) {
            return true;
        }
        else {
            return false;
        }
    }

    //Bouton loading
    function envoie() {
        var btn = document.getElementById('form_photo');
        btn.className = "ui small loading form"
    }
</script>
 
