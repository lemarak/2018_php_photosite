<?php
session_start();
require('../model/model.php');
require('../model/ManagerPhoto.php');
require('../model/Photo.php');
require('../model/Membre.php');
require('../model/ManagerMembre.php');
require('../model/ManagerCritique.php');
require('../model/Critique.php');
require('../model/ress_php.php');

$okConn=verif_login();
?>

<?php
//si nous avons une image
if(!empty($_GET['id_img'])) {

    $idImg = intval($_GET['id_img']);

    //la requète qui récupère l'image à partir de l'identifiant
    $photo=ManagerPhoto::getPhoto($idImg);
    $membre=ManagerMembre::getPseudo('id',$photo->idPSeudo());

    if(empty($photo))
        echo 'L\'image n\'existe pas !';
    else {
        $nom=$photo->nom_fichier() . '.' . $photo->extension();
        $pseudo=$membre['pseudo'];
        $titre=$photo->titre();
        $idTheme=$photo->idTheme();
        $theme=getThemes($photo->idTheme());
        $datePrise=date_format(date_create($photo->datePrise()),'d-m-Y');
        $description=nl2br($photo->description());
        $technique=nl2br($photo->technique());
        $note=$photo->noteGlobale()==0?'pas de note':'Note globale : ' . $photo->noteGlobale() . '/5';
        $nbCrit=ManagerCritique::countCritiques('idPhoto',$idImg);
        $notes=ManagerCritique::getNotesDetail($idImg);
        $critiques=[];
        $critiques=ManagerCritique::getCritiques('idPhoto',$idImg);
        ?>
<?php require('../view/photoView.php'); ?>

<?php
    }
} else
    echo 'Vous n\'avez pas sélectionné d image !';
?>
