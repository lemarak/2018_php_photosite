<?php

/**
 * Created by PhpStorm.
 * User: steph
 * Date: 05/01/2018
 * Time: 11:49
 */

require_once('Manager.php');

class ManagerCritique extends Manager
{

    //Ajout des critiques
    public static function insertNote($idImg, $idPseudo, $tNotes, $tComments, $noteF, $comm)
    {
        try {
            $bdd = self::connexion_bd();

            $req = $bdd->prepare('INSERT INTO critiques ( idPhoto, idVotant, noteIntention, noteTechnique, noteImage, noteRendu, comIntention, comTechnique, comImage, comRendu, noteFinale, critique)
                                    VALUES (:idPhoto,:idVotant,:noteIntention,:noteTechnique,:noteImage,:noteRendu,:comIntention,:comTechnique,:comImage,:comRendu,:noteFinale,:critique) ');

            $rows = $req->execute(array(
                'idPhoto' => $idImg,
                'idVotant' => $idPseudo,
                'noteIntention' => $tNotes[0],
                'noteTechnique' => $tNotes[1],
                'noteImage' => $tNotes[2],
                'noteRendu' => $tNotes[3],
                'comIntention' => $tComments[0],
                'comTechnique' => $tComments[1],
                'comImage' => $tComments[2],
                'comRendu' => $tComments[3],
                'noteFinale' => $noteF,
                'critique' => $comm
            ));
            self::getNoteGlobale($idImg, true);
            return $rows;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    //Compter critiques pour une photo
    public static function countCritiques($id, $idValue)
    {
        try {
            $bdd = self::connexion_bd();
            $req = $bdd->prepare('SELECT COUNT(id) as nbCritiques FROM critiques where  ' . $id . '=?');
            $req->execute(array($idValue));
            $data = $req->fetch();
            if ($data) {
                $nb = $data['nbCritiques'];
            } else {
                $nb = 0;
            }
            $req->closeCursor();
            return $nb;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //Lire une critique
    public static function getCritiques($id, $idValue)
    {
        try {
            $critiques = [];
            $bdd = self::connexion_bd();
            $req = $bdd->prepare('SELECT * FROM critiques where  ' . $id . ' =? ORDER BY DateCritique DESC');
            $req->execute(array($idValue));
            while ($data = $req->fetch()) {
                $critiques[] = new Critique($data);
            }
            return $critiques;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //Supprime critique(s), si idPseudo renseigné, supprime toutes les critiques d'un pseudo
    public static function deleteCritiques($id, $idValue)
    {
        try {
            $bdd = self::connexion_bd();
            $bdd->exec('DELETE FROM critiques WHERE '. $id .' = ' . $idValue);
            return true;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
            return false;
        }
    }

    public static function getNoteGlobale($idPhoto, $maj)
    {
        try {
            $bdd = self::connexion_bd();
            $note = 0;
            $req = $bdd->prepare('SELECT AVG(noteFinale) as moyenne FROM critiques WHERE idPhoto = ? ');
            $req->execute(array($idPhoto));
            $data = $req->fetch();
            if ($data) {
                $note = $data['moyenne'];
            } else {
                $note = 0;
            }
            $req->closeCursor();
            //self->_moyenne=$note;
            if ($maj) {
                $req = $bdd->prepare('UPDATE photos SET noteGlobale=:note WHERE id=:idPhoto');

                $req->execute(array(
                    'note' => $note,
                    'idPhoto' => $idPhoto));
            }
            return $note;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //récupère les notes techniques et maj objet Photo
    public static function getNotesDetail($idPhoto)
    {
        $notes = [];
        $bdd = self::connexion_bd();
        $req = $bdd->prepare('SELECT AVG(noteIntention) as nIntention,
                                    AVG(noteTechnique) as nTechnique,
                                    AVG(noteImage) as nImage,
                                    AVG(noteRendu) as nRendu
                                    FROM critiques WHERE idPhoto = ? ');
        $req->execute(array($idPhoto));
        $data = $req->fetch();
        if ($data) {
            $notes[0] = number_format($data['nIntention'], 1);
            $notes[1] = number_format($data['nTechnique'], 1);
            $notes[2] = number_format($data['nImage'], 1);
            $notes[3] = number_format($data['nRendu'], 1);
        } else {
            $notes[0] = 0;
            $notes[1] = 0;
            $notes[2] = 0;
            $notes[3] = 0;
        }
        $req->closeCursor();
        return $notes;
    }

    //vérifie si un membre a voté pour une photo, renvoie boolean
    public static function verifSiCritique($idVotant, $idPhoto)
    {
        $bExiste = false;
        $bdd = self::connexion_bd();
        $req = $bdd->prepare('SELECT * FROM critiques WHERE idVotant=? AND idPhoto=?');
        $req->execute(array($idVotant, $idPhoto));
        $data = $req->fetch();
        if ($data) {
            $bExiste = true;
        }
        $req->closeCursor();
        return $bExiste;
    }
}