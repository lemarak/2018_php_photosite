<?php

require_once('Manager.php');


function getThemes($idTheme)
{
    try {
        $dbManager = new Manager();
        $bdd = $dbManager->connexion_bd();
        if ($idTheme == 0) {
            $req = $bdd->prepare('SELECT * FROM themes WHERE dansMenu=1 ORDER BY ordreMenu');
            $req->execute();
            return $req;
        } else {
            $req = $bdd->prepare('SELECT * FROM themes WHERE id=' . $idTheme);
            $req->execute();
            $data = $req->fetch();
            $req->closeCursor();
            return $data['libelleTheme'];
        }

    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function getDescThemes($idTheme)
{
    try {
        $dbManager = new Manager();
        $bdd = $dbManager->connexion_bd();

            $req = $bdd->prepare('SELECT * FROM themes WHERE id=' . $idTheme);
            $req->execute();
            $data = $req->fetch();
            $req->closeCursor();
            return $data['descriptionTheme'];

    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

/*****************************************
 * //Lecture des thèmes et renvoie un tableau
 *****************************************/
function getListeThemes()
{

    try {
        $dbManager = new Manager();
        $bdd = $dbManager->connexion_bd();
        $req = $bdd->prepare('SELECT * FROM themes ORDER BY libelleTheme');
        $req->execute();
        while ($data = $req->fetch()) {
            $tab_Theme[$data['id']] = $data['libelleTheme'];
        }
        $req->closeCursor();

        return $tab_Theme;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

/*****************************************
 * //Compteur de vues uniques
 *****************************************/
function insertVues($idPhoto, $idPseudo)
{
    try {
        $dbManager = new Manager();
        $bdd = $dbManager->connexion_bd();
        $req = $bdd->prepare('SELECT * FROM vues WHERE idPhoto=:idPhoto AND idPseudo=:idPseudo');
        $req->execute(array(
            'idPhoto' => $idPhoto,
            'idPseudo' => $idPseudo));
        $data = $req->fetch();
        if (!$data) {
            $req = $bdd->prepare('INSERT INTO vues (idPhoto,idPseudo)
                                      VALUES (:idPhoto,:idPseudo)');
            $rows = $req->execute(array(
                'idPhoto' => $idPhoto,
                'idPseudo' => $idPseudo));
        }

    } catch (Exception $e) {

    }
}

function countVues($idPhoto)
{
    $nb = 0;
    $dbManager = new Manager();
    $bdd = $dbManager->connexion_bd();
    $req = $bdd->query('SELECT COUNT(*) as nbVues FROM vues WHERE idPhoto=' . $idPhoto);
    $data = $req->fetch();
    if ($data) {
        $nb = $data['nbVues'];
    }
    return $nb;
}

/**********************
 * //Vérification du Login
 ***********************/
function verif_login()
{
    if ((isset($_SESSION['pseudo'])) && (!empty($_SESSION['pseudo']))) {
        // le login a été enregistré dans la session, j'affiche le lien du profil
        return true;
    } else {
        // pas de login en session : proposer la connexion
        return false;
    }
}


/*************************************************/
//Créer une miniature à partir de l'image d'origine
/*************************************************/
function creer_miniature($imgVO, $nom, $extension, $taille, $rep)
{
    $ImageChoisie = imagecreatefromjpeg($imgVO);
    $TailleImageChoisie = getimagesize($imgVO);
    if ($TailleImageChoisie[0] > $TailleImageChoisie[1]) {  //largeur>hauteur
        $NouvelleLargeur = $taille;
        $NouvelleHauteur = (($TailleImageChoisie[1] * (($NouvelleLargeur) / $TailleImageChoisie[0])));
    } else {
        $NouvelleHauteur = $taille;
        $NouvelleLargeur = (($TailleImageChoisie[0] * (($NouvelleHauteur) / $TailleImageChoisie[1])));
    }
    $NouvelleImage = imagecreatetruecolor($NouvelleLargeur, $NouvelleHauteur) or die ("Erreur");
    imagecopyresampled($NouvelleImage, $ImageChoisie, 0, 0, 0, 0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0], $TailleImageChoisie[1]);
    imagejpeg($NouvelleImage, $rep . $nom . '.' . $extension, 100); //.$ExtensionPresumee
}
