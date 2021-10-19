<?php

require_once('Manager.php');

class ManagerConcours extends Manager
{

    //Lit le concours et renvoie une instance de Concours
    public static function getConcours($id)
    {
        try {
            $bdd = self::connexion_bd();
            $req = $bdd->prepare('SELECT * FROM concours WHERE id = ?');
            $req->execute(array($id));
            $data = $req->fetch();
            $req->closeCursor();

            return new Concours($data);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //Lit le concours et renvoie une instance de Concours
    public static function getAllConcours()
    {
        try {
            $bdd = self::connexion_bd();
            $concours = [];
            $req = $bdd->query('SELECT * FROM concours WHERE archive=1 ORDER BY dateDebut');
            while ($data = $req->fetch()) {
                $concours[] = new Concours($data);
            }
            $req->closeCursor();

            return $concours;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //Modifier un concours (mode Admin)
    public static function updateConcours($id, Concours $c)
    {
        try {
            $bdd = self::connexion_bd();
            $req = $bdd->prepare('UPDATE concours
                                  SET nom =:nom, theme =:theme, descriptif =:descriptif,
                                  dateDebut =:dateDebut, dateFin =:dateFin, dateDebutVote =:dateDebutVote, dateFinVote =:dateFinVote, actifVote =:actifVote
                                  WHERE id =:id; ');
            $rows = $req->execute(array(
                'id' => $id,
                'nom' => $c->nom(),
                'theme' => $c->theme(),
                'descriptif' => $c->descriptif(),
                'dateDebut' => $c->dateDebut(),
                'dateFin' => $c->dateFin(),
                'dateDebutVote' => $c->dateDebutVote(),
                'dateFinVote' => $c->dateFinVote(),
                'actifVote' => $c->actifVote()
            ));
            return $req->errorInfo();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //Inserer une contribution
    public static function insertParticipation($idConcours, $idPhoto)
    {
        try {
            $bdd = self::connexion_bd();
            $req = $bdd->prepare('INSERT into photo_concours (idConcours,idPhoto,valide)
                                VALUES (?,?,1)');
            $result = $req->execute(array($idConcours, $idPhoto));
            return $result;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
            return $result;
        }
    }

    //Galerie du concours
    public static function getGalerie($idValue, $page = 0, $resultat = 0)
        /*$resultat, photos triées par notes décroissantes
                    = 1 pour affichage page résultat (9 photos)
                    = 2 pour affichage archives (3 photos)
                    = 3 pour toutes les photos
        */
    {
        try {
            $limit = 0;
            if ($page != 0) {
                $limit = ($page - 1) * 9;
            }
            $photos = [];
            $bdd = self::connexion_bd();
            if ($resultat >= 1) { //trié par notes concours décroissantes
                if ($resultat == 1) {
                    $limit = 9;
                } elseif ($resultat == 2) {
                    $limit = 3;
                } else {
                    $limit = 99;
                }
                if ($resultat == 3) {
                    $req = $bdd->prepare('SELECT photos.*,photo_concours.*, SUM(note) as note
                                      FROM photos
                                      RIGHT JOIN photo_concours ON photos.id=photo_concours.idPhoto
                                      LEFT JOIN votes ON photos.id=votes.idPhoto
                                      WHERE photo_concours.idConcours=?
                                      GROUP BY photos.id
                                      ORDER BY note DESC LIMIT 0,' . $limit);
                } else {
                    $req = $bdd->prepare('SELECT photos.*, SUM(note) as note
                                      FROM photos
                                      INNER JOIN votes ON photos.id=votes.idPhoto
                                      WHERE votes.idConcours=?
                                      GROUP BY photos.id
                                      ORDER BY note DESC LIMIT 0,' . $limit);
                }
            } else {
                $req = $bdd->prepare('SELECT photos.* FROM photos,photo_concours WHERE photo_concours.idConcours=? AND photos.id=photo_concours.idPhoto ORDER BY dateDepot DESC LIMIT ' . $limit . ',9');
            }
            $req->execute(array($idValue));
            while ($data = $req->fetch()) {
                $photos[] = new Photo($data);
            }
            $req->closeCursor();
            return $photos;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //Calculer le nombre de dépots d'un participant (idMembre) pour un concours (idConcours)
    public static function getParticipationConcours($idConcours, $idMembre)
    {
        try {
            $bdd = self::connexion_bd();
            $req = $bdd->prepare('SELECT count(idPhoto) AS nbPhotos FROM photo_concours AS co,photos AS p
                                  WHERE co.idPhoto=p.id AND co.idConcours=? AND p.idPseudo=?');
            $req->execute(array($idConcours, $idMembre));
            $data = $req->fetch();
            $req->closeCursor();
            return $data['nbPhotos'];
        } catch (Exception $e) {

        }
    }

    //vérifie si une photo a déja été soumise à un concours
    public static function verifDepotConcours($idConcours, $idPhoto)
    {
        $bExiste = false;
        $bdd = self::connexion_bd();
        $req = $bdd->prepare('SELECT * FROM photo_concours WHERE idConcours=? AND idPhoto=?');
        $req->execute(array($idConcours, $idPhoto));
        $data = $req->fetch();
        if ($data) {
            $bExiste = true;
        }
        $req->closeCursor();
        return $bExiste;
    }

    public static function insertVote($idConcours, $idPhoto, $idVotant, $note)
    {
        $result = false;
        $reqStr = "INSERT (id,idConcours,idPhoto,idVotant,note) INTO votes VALUES ('',:idConcours,:idPhoto,:idVotant,:note)";
        try {
            $bdd = self::connexion_bd();
            $req = $bdd->prepare('INSERT INTO votes (idConcours,idPhoto,idVotant,note) VALUES (:idConcours,:idPhoto,:idVotant,:note)');
            $result = $req->execute(array(
                'idConcours' => $idConcours,
                'idPhoto' => $idPhoto,
                'idVotant' => $idVotant,
                'note' => $note));
            return $result;
        } catch (Exception $e) {
            return $reqStr;
        }
    }

    //Renvoie un tableau des notes (1,2,3) d'un votant pour un concours
    public static function verifSiVote($idConcours, $idVotant)
    {
        try {
            $bdd = self::connexion_bd();
            $notes = [];
            $req = $bdd->prepare('SELECT note FROM votes
                              WHERE idConcours=:idConcours AND idVotant=:idVotant');
            $req->execute(array(
                'idConcours' => $idConcours,
                'idVotant' => $idVotant));
            while ($data = $req->fetch()) {
                $notes[] = $data['note'];
            }
            $req->closeCursor();
            return $notes;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //Renvoie la note des photos pour un concours
    public static function getNotes($idConcours)
    {
        try {
            $bdd = self::connexion_bd();
            $idPhotos = [];
            $req = $bdd->prepare('SELECT idPhoto, SUM(note) as result  FROM votes
                                  WHERE idConcours=?
                                  GROUP BY idPhoto');;
            $req->execute(array($idConcours));
            while ($data = $req->fetch()) {
                $idPhotos[$data['idPhoto']] = $data['result'];
            }
            $req->closeCursor();
            return $idPhotos;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //Compte le nombre de photos pour un concours, renvoie le total
    public static function countPhotoConcours($idConcours)
    {
        try {
            $bdd = self::connexion_bd();
            $req = $bdd->prepare('SELECT count(DISTINCT idPhoto) as nb FROM photo_concours
                                WHERE idConcours=?');
            $req->execute(array($idConcours));
            $data = $req->fetch();

            $req->closeCursor();
            return $data['nb'];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //Suppression dans photo_concours
    public static function deleteVotes($id, $idValue)
    {
        try {
            $bdd = self::connexion_bd();
            $bdd->exec('DELETE FROM photo_concours WHERE ' . $id . ' = ' . $idValue);
            return true;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
            return false;
        }
    }

}