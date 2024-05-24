<!-- inclusion des variables et fonctions -->
<?php
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Page d'accueil</title>
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
    >
    <link
            href="style.css"
            rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
       <!-- footer du site -->
    <?php require_once(__DIR__ . '/views/header.php'); ?>
    
       <!-- contenu du site -->
    <div class="container">
        <h1>Vos inspirations <span class="text-primary">culinaires</span>.</h1>
        <?php require_once(__DIR__ . '/views/widget.php'); ?>
    </div>

    <!-- footer du site -->
    <?php require_once(__DIR__ . '/views/footer.php'); ?>
</body>
</html>