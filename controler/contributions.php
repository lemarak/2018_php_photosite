<?php
session_start();
require('../model/model.php');
require('../model/ManagerMembre.php');
require('../model/ManagerPhoto.php');
require('../model/ManagerCritique.php');
require('../model/Photo.php');
require('../model/ress_php.php');
$okConn=verif_login();

?>

<?php

if (!isset($_GET['page'])) {
    $page=1;
}
else {
    $page=$_GET['page'];
}


$maxPages=ceil(ManagerPhoto::countPhoto('',0)/9);
$photos=[];
$photos=ManagerPhoto::getGalerie('',0,$page);
$for='contributions';
require('../view/contributionsView.php');


?>