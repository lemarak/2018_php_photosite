<?php
session_start();

require('../model/model.php');
require('../model/ManagerConcours.php');
require('../model/ManagerMembre.php');
require('../model/Concours.php');
require('../model/Photo.php');

$okConn = verif_login();

$concours = ManagerConcours::getAllConcours();

foreach($concours as $c) {
    $p=ManagerConcours::getGalerie($c->id(),0,2);
    $photoConcours[$c->id()]=$p;
}
require('../view/listeConcoursView.php');
