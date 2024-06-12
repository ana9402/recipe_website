<?php
require_once (__DIR__ . '/core/init.php');
$pageTitle = 'Hello';

ob_start();

if (isset($_SESSION["flash"]))
{
    vprintf("<div class='alert alert-success' role='alert' %s>%s</div>", $_SESSION["flash"]);
    unset($_SESSION["flash"]);
}
?>

<div class="main-container">
    <div class="container p-5">
        <h1>Vos inspirations <span class="text-secondary">culinaires</span>.</h1>
        <div class="row recipe_list d-flex justify-content-between">
            <?php foreach (getRecipes($recipes) as $recipe) : ?>
                <?php require (__DIR__ . '/views/recipe-thumbnail.php'); ?>
            <?php endforeach ?>
        </div>
    </div>
</div>


<?php
$content = ob_get_clean();
require_once (__DIR__ . '/views/layout.php');
?>