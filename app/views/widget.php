<?php
require_once(__DIR__ . '/../core/init.php');
require_once(__DIR__ . '/../config/mysql.php');
require_once(__DIR__ . '/../databaseconnect.php');

$sql = "SELECT * from recipes";
$stmt = $mysqlClient->query($sql);

$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC)

?>

<!-- widget.php -->
<div class="container my-5" id="last-recipes">
    <div class="row mb-3">
        <h2>
            Last published recipes
        </h2>
    </div>

    <div class="row recipe_list d-flex gap-4">
        <?php foreach (getRecipes($recipes) as $recipe) : ?>
            <div class="col-md-3 recipe_thumbnail p-4">
                <h3><?php echo $recipe['title']; ?></h3>
                <h3><?php echo $recipe['user_id']; ?></h3>
                <div><?php echo $recipe['rating']; ?></div>
                <button type="button" class="btn btn-secondary"><a href="recipe-template.php?id=<?php echo htmlspecialchars($recipe['id'])?>">Voir</a></button>
            </div>
        <?php endforeach ?>
    </div>
</div>