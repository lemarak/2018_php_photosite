<?php

/**
 * Created by PhpStorm.
 * User: STEPH
 * Date: 16/12/2017
 * Time: 14:55
 */

require_once('Manager.php');


class ManagerMembre extends Manager
{

    //*** Ajoute un membre ***
    public static function insertMembre(Membre $m)
    {
        try {
            $bdd = self::connexion_bd();
            $req = $bdd->prepare('INSERT INTO membres (nom,prenom,pseudo,pwd,email,presentation) VALUES (:nom,:prenom,:pseudo,:pwd,:email, :presentation) ') or die(print_r($bdd->errorInfo()));
            $rows = $req->execute(array(
                'nom' => $m->nom(),
                'prenom' => $m->prenom(),
                'email' => $m->email(),
                'pwd' => $m->pwd(),
                'pseudo' => $m->pseudo(),
                'presentation'=> $m->presentation()
            ));
            $_SESSION['pseudo'] = $m->pseudo();
            //$data = self::getPseudo('pseudo',$m->pseudo());
            $_SESSION['id_pseudo'] = $bdd->lastInsertId();
            //echo $m->affiche();
            return $bdd->lastInsertId();
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //*** Modifie un membre ***
    public static function updateMembre(Membre $m,$id)
    {
        try {
            $bdd = self::connexion_bd();
            $req = $bdd->prepare('UPDATE membres SET nom=:nom,prenom=:prenom,pseudo=:pseudo,email=:email, presentation=:presentation WHERE id=:id ');
            $rows = $req->execute(array(
                'id'=>$id,
                'nom' => $m->nom(),
                'prenom' => $m->prenom(),
                'email' => $m->email(),
                //'pwd' => $m->pwd(),//
                'pseudo' => $m->pseudo(),
                'presentation'=> $m->presentation()
            ));
            return true;
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //*** Lecture et renvoie d'un Membre ***
    public static function getMembre($id)
    {
        $id = (int) $id;
        try {
            $bdd = self::connexion_bd();
            $req = $bdd->query('SELECT * FROM membres WHERE id = ' . $id);
            $data = $req->fetch(PDO::FETCH_ASSOC);
            $req->closeCursor();
            return new Membre($data);
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    //*** supprime membre ***
    public static function deleteMembre($id){
        try {
            $bdd = self::connexion_bd();
            $bdd->exec('DELETE FROM membres WHERE id = '.$id );
            return true;
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
            return false;
        }
    }

    //*** Lecture et renvoie de tous les membres ***
    public static function getMembres()
    {
        $membres=[];
        try {
            $bdd = self::connexion_bd();
            $req = $bdd->query('SELECT * FROM membres WHERE pseudo <> \'admin\' ORDER BY pseudo');
            while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
                $membres[]=new Membre($data);
            }
            $req->closeCursor();
            return $membres;
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public static function getPseudo($for,$strPseudo)
    {
        try {
            $bdd = self::connexion_bd();
            $req = $bdd->prepare('SELECT id,pseudo,pwd FROM membres WHERE ' . $for . '=? ');
            $req->execute(array($strPseudo));
            $data=$req->fetch();
            $req->closeCursor();
            return $data;
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public static function getEmail($mail)
    {
        try {
            $bdd = self::connexion_bd();
            $req=$bdd->prepare('SELECT * FROM membres WHERE email= ? ');
            $req->execute(array($mail));
            $data=$req->fetch();
            $req->closeCursor();
            return $data;
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}