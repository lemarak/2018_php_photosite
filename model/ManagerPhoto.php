<?php

/**
 * Created by PhpStorm.
 * User: STEPH
 * Date: 16/12/2017
 * Time: 16:31
 */
require_once('Manager.php');

class ManagerPhoto extends Manager
{

    //Lecture d'une photo par son identifiant
    public static function getPhoto($id)
    {
        try {
            $bdd = self::connexion_bd();
            $req = $bdd->prepare('SELECT * FROM photos WHERE id = ?');
            $req->execute(array($id));
            $data=$req->fetch();
            $req->closeCursor();

            return new Photo($data);
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public static function getGalerie($id,$idValue,$page=0,$admin=0,$tri='')
    {
        try {
            $limit=0;
            if($tri=='') {
                $strTri='ORDER BY date_creation DESC';
            } elseif($tri=='&tri=note') {
                $strTri='ORDER BY noteGlobale DESC';
            }
            if ($page!=0) {
                $limit=($page-1)*9;
            }
            $photos=[];
            $bdd = self::connexion_bd();
            if ($id==''){ //Contributions
                $req = $bdd->query('SELECT * FROM photos '.$strTri.' LIMIT ' . $limit . ',9');
            }
            elseif ($id=='idPseudo') { // Profil
                $req = $bdd->prepare('SELECT * FROM photos WHERE ' . $id . '=?');
                $req->execute(array($idValue));
            }
            elseif ($admin==1) {  //admin
                $req = $bdd->prepare('SELECT * FROM photos WHERE ' . $id . '=? ORDER BY date_creation DESC');
                $req->execute(array($idValue));
            }
            else {      //Thème
                $req = $bdd->prepare('SELECT * FROM photos WHERE ' . $id . '=? '.$strTri.' LIMIT ' . $limit . ',9');
                $req->execute(array($idValue));
            }
            while($data = $req->fetch()) {
                $photos[]=new Photo($data);
            }
            $req->closeCursor();
            return $photos;
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //*** supprime photo ***
    public static function deletePhoto($id){
        try {
            $bdd = self::connexion_bd();
            $bdd->exec('DELETE FROM photos WHERE id = '.$id );
            return true;
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
            return false;
        }
    }


    public static function countPhoto($id,$idValue)
    {
        try {
            $bdd = self::connexion_bd();
            if ($id==''){
                $req = $bdd->query('SELECT COUNT(id) as nbPhotos FROM photos');
            }
            else {
                $req = $bdd->prepare('SELECT COUNT(id) as nbPhotos FROM photos where ' . $id . '=?');
                $req->execute(array($idValue));
            }
            $data=$req->fetch();
            if ($data) {
                $nb=$data['nbPhotos'];
            }
            else {
                $nb=0;
            }
            $req->closeCursor();
            return $nb;
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //Ajout d'une photo
    public static function insertPhoto(Photo $p)
    {
        try {
            $bdd = self::connexion_bd();

            $req = $bdd->prepare('INSERT INTO photos (titre,nom_fichier,extension,description,technique,camera,objectif,lieu,datePrise,idPseudo,idTheme,noteGlobale)
                                  VALUES (:titre,:nom_fichier,:extension,:description,:technique,:camera,:objectif,:lieu,:datePrise,:idPseudo,:idTheme,0) ');
            $rows = $req->execute(array(
                'titre' => $p->titre(),
                'nom_fichier' => $p->nom_fichier(),
                'extension' => $p->extension(),
                'description' => $p->description(),
                'technique' => $p->technique(),
                'camera' => $p->camera(),
                'objectif' => $p->objectif(),
                'lieu' => $p->lieu(),
                'datePrise' => $p->datePrise(),
                'idPseudo' => $p->idPSeudo(),
                'idTheme' => $p->idTheme()
            ));
            return $bdd->lastInsertId();
        }
        catch (Exception $e) {
            //die('Erreur : ' . $e->getMessage());
            return 'Erreur : ' . $e->getMessage();
        }
    }

    //Retoune le pseudo d'une photo
    public static function getPseudoPhoto($id)
    {
        try {
            $bdd = self::connexion_bd();
            $req = $bdd->prepare('SELECT idPseudo FROM photos WHERE id = ?');
            $req->execute(array($id));
            $data=$req->fetch();
            $req->closeCursor();
            return ($data['idPseudo']);
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}