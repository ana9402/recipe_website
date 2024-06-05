<?php
require_once(__DIR__ . '/../core/init.php');
require_once(__DIR__ . '/../config/mysql.php');
require_once(__DIR__ . '/../databaseconnect.php');
$pageTitle = 'Les recettes';
ob_start();
?>

<!-- Recipes list -->
<section id="recipes-section">
    <div class="container p-5">
        <div class="row mb-3">
            <h1 class="text-center">
                Les recettes
            </h1>
        </div>

        <div class="row recipe_list d-flex justify-content-between">
            <?php foreach (getRecipes($recipes) as $recipe) : ?>
                <?php require (__DIR__ . '/../views/recipe-thumbnail.php'); ?>
            <?php endforeach ?>
        </div>
    </div>
</section>


<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../views/layout.php');
?>