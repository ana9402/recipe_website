<?php
require_once(__DIR__ . '/./core/init.php');
require_once(__DIR__ . '/./config/mysql.php');
require_once(__DIR__ . '/./databaseconnect.php');
$pageTitle = 'Les recettes';
ob_start();
?>
<?php
    $sql = "SELECT * from recipes";
    $stmt = $mysqlClient->query($sql);

    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC)

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
                <div class="col-md-3 mb-3 recipe_thumbnail">
                <a href="recipe-template.php?id=<?php echo htmlspecialchars($recipe['id'])?>">
                    <figure class="recipe_thumbnail-img">
                        <img src="<?php echo $recipe['illustration']?>"/>
                    </figure>
                    <h3><?php echo $recipe['title']; ?></h3>
                </a>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>


<?php
$content = ob_get_clean();
require_once(__DIR__ . '/views/layout.php');
?>