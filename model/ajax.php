<?php
require_once('../model/ManagerConcours.php');
require_once('../model/ManagerPhoto.php');

if (isset($_GET['vote'])) { // Code pour le vote
    $result=1;
    //if (isset($_GET['idConcours']) && isset($_GET['idPhoto']) && isset($_GET['idVotant'])) {
        $result = ManagerConcours::insertVote($_GET['idConcours'], $_GET['idPhoto'], $_GET['idVotant'], $_GET['note']);
    //}
    echo $result;
} else {  //code pour participation à un concours
    if (isset($_GET['idConcours']) && isset($_GET['idPhoto'])) {
        $result = ManagerConcours::insertParticipation($_GET['idConcours'], $_GET['idPhoto']);
    }
    if ($result) {
        $idPseudo = ManagerPhoto::getPseudoPhoto($_GET['idPhoto']);
        $nb = ManagerConcours::getParticipationConcours($_GET['idConcours'], $idPseudo);
        echo $nb;
    } else {
        echo 0;
    }
}