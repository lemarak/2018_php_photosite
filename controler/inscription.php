<?php
session_start();
require_once('../model/model.php');
require_once('../model/Membre.php');
require_once('../model/ManagerMembre.php');
require_once('../model/ress_php.php');
$okConn = verif_login();

?>

<?php
function affiche_form($bRetour, $message)
{ /*Affiche le formulaire
                                     $bRetour si retour aprés échec, permet d'afficher les valeurs saisies*/
    //$modif = false;
    if ($bRetour) {
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $pwd = htmlspecialchars($_POST['pwd']);
        $email = htmlspecialchars($_POST['email']);
        $presentation = htmlspecialchars($_POST['presentation']);
        $modif=$_POST['modif'];
    } elseif (isset($_GET['modif']) && isset($_SESSION['id_pseudo'])) {
        $modif = 1;
        $id =$_SESSION['id_pseudo'];
        $membre = ManagerMembre::getMembre($_SESSION['id_pseudo']);
        $nom = $membre->nom();
        $prenom = $membre->prenom();
        $pseudo = $membre->pseudo();
        $pwd = $membre->pwd();
        $email = $membre->email();
        $presentation = $membre->presentation();
    } else {
        $nom = '';
        $prenom = '';
        $pseudo = '';
        $pwd = '';
        $email = '';
        $presentation = '';
        $modif=0;
    }
    // *****  Formulaire d'inscription *****
    require('../view/formInscriptionView.php');
}

?>

<?php require('../view/inscriptionView.php'); ?>

<script>
    function surligne(champ, erreur) {
        if (erreur)
            champ.parentElement.className = "ui corner labeled input error";
        else
            champ.parentElement.className = "ui corner labeled input";
    }

    function verifChamp(champ, id) {
        if (champ.value == '') {
            surligne(champ, true);
            document.getElementById(id).className = "ui pointing red basic label";
            document.getElementById(id).innerHTML = "Saisie obligatoire";
            return false;
        }
        else {
            surligne(champ, false);
            document.getElementById(id).className = "hidden";
            document.getElementById(id).innerHTML = "";
            return true;
        }
    }
    function verifPseudo(champ) {
        if (champ.value.length <= 3 || champ.value.length > 25) {
            surligne(champ, true);
            document.getElementById('errPseudo').className = "ui pointing red basic label";
            document.getElementById('errPseudo').innerHTML = "Taille incorrecte, entre 4 et 25 caractères";
            return false;
        }
        else {
            surligne(champ, false);
            document.getElementById('errPseudo').className = "hidden";
            document.getElementById('errPseudo').innerHTML = "";
            return true;
        }
    }
    function verifEmail(champ) {
        var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
        if (!regex.test(champ.value)) {
            surligne(champ, true);
            document.getElementById('errEmail').innerHTML = "Adresse incorrecte";
            return false;
        }
        else {
            surligne(champ, false);
            document.getElementById('errEmail').innerHTML = "";
            return true;
        }
    }

    function verifPwd() {
        var pwd1 = document.getElementById('pwd'),
            pwd2 = document.getElementById('pwd2');
        if (verifChamp(pwd2, 'errPwd2')) {
            if (pwd1.value !== pwd2.value) {
                surligne(pwd2, true);
                document.getElementById('errPwd2').className = "ui pointing red basic label";
                document.getElementById('errPwd2').innerHTML = "Mot de passe différent";
                return false;
            }
            else {
                surligne(pwd2, false);
                document.getElementById('errPwd2').className = "hidden";
                document.getElementById('errPwd2').innerHTML = "";
                return true;
            }
        }
    }

    function verifCond() {
        var okCond=document.getElementById('cond'),
            modif=document.getElementById('modif').value;
        if (modif==1 || okCond.checked) {
            surligne(okCond, false);
            document.getElementById('errCond').className = "hidden";
            document.getElementById('errCond').innerHTML = "";
            return true;
        }
        else {
            surligne(okCond, true);
            document.getElementById('errCond').className = "ui left pointing red basic label";
            document.getElementById('errCond').innerHTML = "Vous devez accepter les termes et conditions";
            return false;
        }

    }

    function verifForm(f) {
        okNom = verifChamp(f.nom, 'errNom');
        okPwd = verifChamp(f.pwd, 'errPwd');
        okCompare = verifPwd();
        okPwd2 = verifChamp(f.pwd, 'errPwd2');
        okPseudo = verifPseudo(f.pseudo);
        okEmail = verifEmail(f.email);
        okCond=verifCond(f.cond);
        if (okNom && okPwd && okPwd2 && okCompare && okPseudo && okEmail && okCond) {
            return true;
        }
        else {
            return false;
        }
    }
</script> 
