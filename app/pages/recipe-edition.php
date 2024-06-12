<?php
    require_once(__DIR__ . '/../core/init.php');
    require_once(__DIR__ . '/../config/mysql.php');
    require_once(__DIR__ . '/../databaseconnect.php');
    $pageTitle = 'Partager une recette';

    ob_start();

?>

<!-- contenu du site -->
<section id="newRecipe-section" class="">
    <?php require_once(__DIR__ . '/../views/recipe-form.php'); ?>
</section>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../views/layout.php');
?>