<?php

require_once('../model/ManagerPhoto.php');
require_once('../model/Photo.php');
require_once('../model/Critique.php');
require_once('../model/ManagerCritique.php');
require_once('../model/ManagerMembre.php');
require_once('../model/Concours.php');
require_once('../model/ManagerConcours.php');

//Suppression Membre
if (isset($_GET['membre'])) {

    //suppression des photos
    $photos = ManagerPhoto::getGalerie('idPseudo', $_GET['membre']);
    foreach ($photos as $p) {
        if (ManagerPhoto::deletePhoto($p->id())) {
            $nom = $p->nom_fichier() . '.' . $p->extension();
            unlink('../public/photos/apercu/ap_' . $nom);
            unlink('../public/photos/mini/mini_' . $nom);
        }
    }
    unset($photos);

    //suppression des critiques
    $pcs = ManagerCritique::getCritiques('idVotant', $_GET['membre']);
    ManagerCritique::deleteCritiques('idVotant', $_GET['membre']);
    foreach ($pcs as $pc) {
        ManagerCritique::getNoteGlobale($pc->idPhoto(), true);
    }
    //suppression du membre
    ManagerMembre::deleteMembre($_GET['membre']);

    echo 1;
} elseif (isset($_GET['photo'])) {
    //suppression de la photo
    $idPhoto = $_GET['photo'];
    $p = ManagerPhoto::getPhoto($idPhoto);
    if (ManagerPhoto::deletePhoto($idPhoto)) {
        $nom = $p->nom_fichier() . '.' . $p->extension();
        unlink('../public/photos/apercu/ap_' . $nom);
        unlink('../public/photos/mini/mini_' . $nom);
    }

    //suppression critiques photo
    ManagerCritique::deleteCritiques('idPhoto', $idPhoto);

    //suppression votes photo
    ManagerConcours::deleteVotes('idPhoto', $idPhoto);

    echo 1;
}

if (isset($_POST['id'])) {
    $c = new Concours([
        'id'=>$_POST['id'],
        'nom'=>htmlspecialchars($_POST['nom']),
        'theme'=>htmlspecialchars($_POST['theme']),
        'descriptif'=>htmlspecialchars($_POST['descriptif']),
        'mois'=>'',
        'annee'=>'',
        'dateDebut'=>$_POST['dateDebut'],
        'dateFin'=>$_POST['dateFin'],
        'actifDepot'=>'',
        'dateDebutVote'=>$_POST['dateDebutVote'],
        'dateFinVote'=>$_POST['dateFinVote'],
        'actifVote'=>$_POST['actifVote']==true?1:0,
        'archive'=>'',
        'dateCreation'=>''
    ]);
    $retour = ManagerConcours::updateConcours($_POST['id'], $c);
    echo $_POST['actifVote'];

}