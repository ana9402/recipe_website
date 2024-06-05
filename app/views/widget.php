<?php
require_once(__DIR__ . '/../core/init.php');
require_once(__DIR__ . '/../config/mysql.php');
require_once(__DIR__ . '/../databaseconnect.php');

$sql = "SELECT * from recipes";
$stmt = $mysqlClient->query($sql);

$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC)

?>

<!-- widget.php -->
<div class="container my-5" id="last-recipes-widget">
    <div class="row mb-3">
        <h2>
            Les dernières recettes
        </h2>
    </div>

    <div class="row recipe_list d-flex gap-4">
        <?php foreach (getRecipes($recipes) as $recipe) : ?>
            <?php require_once(__DIR__ . './recipe-thumbnail.php'); ?>
        <?php endforeach ?>
    </div>
</div>