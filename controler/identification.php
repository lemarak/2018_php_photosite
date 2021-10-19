<?php
    session_start();
    require_once('../model/ManagerMembre.php');
    require_once('../model/model.php');
    require_once('../model/ress_php.php');
    $okConn=verif_login();
?>

<?php
    $ok=false;
    $erreur=false;
    if (isset($_POST['pseudo']) && isset($_POST['pwd']))
    {
        $data=ManagerMembre::getPseudo('pseudo',$_POST['pseudo']);
        //$data=$req->fetch();
        if ($data['pwd']==md5($_POST['pwd']))
        {
            session_regenerate_id(true);
            $_SESSION['pseudo']=$data['pseudo'];
            $_SESSION['id_pseudo']=$data['id'];
            $ok=true;
        }
        else
        {
            session_regenerate_id(true);
            unset($_SESSION['pseudo']);
            unset($_SESSION['id_pseudo']);
            $ok=false;
            $erreur=true;
        }
        //$req->closeCursor();
    }
    else {
        $_SESSION['url_appel']=$_SERVER['HTTP_REFERER'];
        if (preg_match('/profil/i',$_SESSION['url_appel'])){
            $_SESSION['url_appel']='../controler/index.php';
        }
    }
    $okConn=verif_login();
?>

<?php require('../view/identificationView.php'); ?>