<?php $title = "Inscription" ?>

<?php ob_start(); ?>

<?php

if (!isset($_POST['nom'])) {
    affiche_form(false, '');
} else {
    $strMessage = "ok";
    $bOK = true;

    if (empty($_POST['nom']) || empty($_POST['email']) || empty($_POST['pseudo'])) {
        $strMessage = "Tous les champs n'ont pas été saisis";
        $bOK = false;
    } else {

        if (!$_POST['modif']) {

            /*Verifier si pseudo existe */
            $data = ManagerMembre::getPseudo('pseudo', $_POST['pseudo']);
            if ($data) {
                $strMessage = 'Le pseudo ' . $data['pseudo'] . ' existe déjà';
                $bOK = false;
            }

            /* Vérifier si email existe */
            $data = ManagerMembre::getEmail($_POST['email']);
            if ($data) {
                $strMessage = 'L\'adresse mail ' . $data['email'] . ' existe déjà';
                $bOK = false;
            }
        }

    }
    if ($bOK) {
        $membre = new Membre([
            'id' => 0,
            'nom' => htmlspecialchars($_POST['nom']),
            'prenom' => htmlspecialchars($_POST['prenom']),
            'pseudo' => htmlspecialchars($_POST['pseudo']),
            'pwd' => md5($_POST['pwd']),
            'email' => htmlspecialchars($_POST['email']),
            'presentation' => htmlspecialchars($_POST['presentation']),
            'dateCreation' => ''
        ]);

        if ($_POST['modif'] == 1) {
            //modif
            ManagerMembre::updateMembre($membre, $_SESSION['id_pseudo']);
            $lastId=$_SESSION['id_pseudo'];
            $_SESSION['pseudo']=$_POST['pseudo'];
        } else {
            //insert
            $lastId = ManagerMembre::insertMembre($membre);
        }

        /*Vérifier si tout OK */
        if ($lastId) {
            header('Location: profil.php?id=' . $lastId);
        } else {

        }
    } else {
        //-require('../view/viewRess/errorView.php');
        affiche_form(true, $strMessage);
    }
}
?>


<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>