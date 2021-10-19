<?php
session_start();

require_once('../model/Membre.php');
require_once('../model/ManagerMembre.php');
require_once('../model/Photo.php');
require_once('../model/ManagerPhoto.php');
require_once('../model/Critique.php');
require_once('../model/ManagerCritique.php');
require_once('../model/Concours.php');
require_once('../model/ManagerConcours.php');
require_once('../model/model.php');

if (isset($_SESSION['pseudo']) && $_SESSION['pseudo']=='admin') {
    $okConn=verif_login();

    $membres=ManagerMembre::getMembres();

    $themes=getListeThemes();
    $photos=[];
    $themesPhotos=[];
    foreach($themes as $key=>$theme){
        $photos=ManagerPhoto::getGalerie('idTheme',$key,0,1);
        $themesPhotos[$key]=$photos;
    }
    $concours=[];
    $concours=ManagerConcours::getAllConcours();

    require('../view/adminView.php');
} else {
    header('location:index.php');
}

