<?php
session_start();

require('../model/model.php');
require('../model/ManagerConcours.php');
require('../model/ManagerMembre.php');
require('../model/ManagerCritique.php');
require('../model/Concours.php');
require('../model/Photo.php');

$okConn = verif_login();

if (isset($_GET['id'])) {
    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }
    $nbPhotos = ManagerConcours::countPhotoConcours($_GET['id']);
    $maxPages = ceil($nbPhotos / 9);
    $concours = ManagerConcours::getConcours($_GET['id']);
    $idConcours = $concours->id();
    $photos = [];
    if (isset($_GET['resultats']) && $_GET['resultats'] == 1) {
        $photos = ManagerConcours::getGalerie($_GET['id'], $page, 1);
    } else {
        $photos = ManagerConcours::getGalerie($_GET['id'], $page);
    }
    require('../view/concoursView.php');
}
