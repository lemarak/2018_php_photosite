<?php
session_start();
require_once('../model/model.php');
require_once('../model/ManagerPhoto.php');
require_once('../model/ManagerCritique.php');
require_once('../model/Photo.php');
require_once('../model/ress_php.php');
$okConn = verif_login();
if (!$okConn) {
    header('Location:index.php');
}
?>

<?php
$idImg = intval($_GET['id_img']);
$photo = ManagerPhoto::getPhoto($idImg);

$nom = $photo->nom_fichier() . '.' . $photo->extension();


$tabCrit = array('Intention',
    'Technique',
    'Mise en image',
    'Rendu global');

$tabCritComment = array('La compréhension de l\'intention du photographe (objective et subjective)',
    'Maitrise technique (cadrage, choix Iso, ouverture, traitement N&B, gestion des couleurs...). Subjectif ',
    'Principalement la composition et le cadrage. L\'appréciation est à la fois objective et subjective',
    'Qualité de la photo d\'un point de vue artistique, appréciation subjective');

if (isset($_POST['tabNote'])) { //Etape 1/2
    $tabNotes = $_POST['tabNote'];
    $tabComments = $_POST['tabComment'];
    if (count($tabNotes) < 4) {
        $error = "Toutes les notes n'ont pas été saisies";
        require('../view/critiqueView.php');
    } else {
        $noteFinale = $photo->calculNote($tabNotes);
        $_SESSION['tabNotes'] = $tabNotes;
        $_SESSION['tabComments'] = $tabComments;
        $_SESSION['noteFinale'] = $noteFinale;
        $insert = false;
        require('../view/critiqueView2.php');
        //echo $tabNotes[0];
    }
} elseif (isset($_POST['comment'])) {      //Etape 2/2
    $okInsert = ManagerCritique::insertNote($idImg, $_SESSION['id_pseudo'], $_SESSION['tabNotes'], $_SESSION['tabComments'], $_SESSION['noteFinale'], $_POST['comment']);
    if ($okInsert) {
        $insert = true;
        header('Location:photo.php?id_img=' . $idImg);
        exit();
        //require('../view/voteView2.php');
    } else {
        echo $okInsert;
    }
} else {
    $error = "";
    //intialisation des variables tab pour value
    for ($n=0;$n<4;$n++){
        $tabComments[]='';
        $tabNotes[]=0;
    }
    require('../view/critiqueView.php');
}
?>