<!DOCTYPE HTML>

<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>PhotoSite - Concours photos et critiques en ligne</title>

    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/semantic.css">

</head>

<body>


<!-- Menu Haut -->

<div class="ui page grid">
    <div class="column">
        <?php include('viewRess/menu_haut.php'); ?>
    </div>
</div>

<?= $content ?>

<!-- Footer-->
<?php include('viewRess/footer.php'); ?>

</body>
</html>