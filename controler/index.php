<?php
    session_start();
    require_once('../model/model.php');
    require_once('../model/ress_php.php');
    require_once('../model/Manager.php');
    $okConn=verif_login();
    /*$bdd=Manager->connexion_bd();*/
?>

<?php

require('../view/indexView.php'); ?>