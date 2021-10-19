<?php
    session_start();
    unset($_SESSION['pseudo']);
    unset($_SESSION['id_pseudo']);
    session_regenerate_id(true);
//$_SESSION['url_appel']=$_SERVER['HTTP_REFERER'];
    header('Location:'. $_SERVER['HTTP_REFERER']);
?>