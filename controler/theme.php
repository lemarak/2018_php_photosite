<?php
session_start();
require('../model/model.php');
require('../model/ManagerMembre.php');
require('../model/ManagerPhoto.php');
require('../model/ManagerCritique.php');
require('../model/Photo.php');
require('../model/ress_php.php');
$okConn = verif_login();
//$data=getThemes($_GET['idTheme']);
?>

<?php
$idTheme = $_GET['idTheme'];
//$data=$req->fetch();
$theme = getThemes($_GET['idTheme']);
$descTheme = nl2br(getDescThemes($_GET['idTheme']));

//Page
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

//Tri
if (!isset($_GET['tri'])) {
    $tri='';
}else {
    $tri='&tri=note';
}

$c = new ManagerCritique();
$maxPages = ceil(ManagerPhoto::countPhoto('idTheme', $idTheme) / 9);
$photos = [];
$photos = ManagerPhoto::getGalerie('idTheme', $idTheme, $page,0,$tri);
require('../view/themeView.php');
?>