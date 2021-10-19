<?php
session_start();
require('../model/model.php');
require('../model/ress_php.php');
require('../model/ManagerMembre.php');
require('../model/ManagerPhoto.php');
require('../model/ManagerCritique.php');
require('../model/Membre.php');
require('../model/Photo.php');
require('../model/Critique.php');
$okConn = verif_login();

?>

<?php
if (isset($_GET['id'])) {
    $membre = ManagerMembre::getMembre($_GET['id']);
    $modif=($okConn && ($_SESSION['id_pseudo']==$_GET['id']));
} else {
    $membre = ManagerMembre::getMembre($_SESSION['id_pseudo']);
    $modif=$okConn;
}
$critiques = [];
$critiques = ManagerCritique::getCritiques('idVotant', $membre->id());
$photos = [];
$photos = ManagerPhoto::getGalerie('idPseudo', $_GET['id']);

require('../view/profilView.php');
?>