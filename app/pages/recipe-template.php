<?php

require_once (__DIR__ . '/../core/init.php');
require_once (__DIR__ . '/../config/mysql.php');
require_once (__DIR__ . '/../databaseconnect.php');
$pageTitle = 'Recette';

ob_start();

$id = $_GET['id'];
$sql = 'SELECT recipes.*, categories.name AS category_name, users.username as user_name
        FROM recipes
        LEFT JOIN categories ON recipes.category_id = categories.id
        LEFT JOIN users ON recipes.user_id = users.user_id
        WHERE recipes.id = :id';
$stmt = $mysqlClient->prepare($sql);
$stmt->execute(['id' => $id]);
$recipe = $stmt->fetch();

if(isset($_SESSION['user_id']) && $recipe['user_id'] == $_SESSION['user_id']) 
{
    $isAuthor = true;
}

?>

<section id="recipeTemplate-section">
    <div class="container p-5">
        <div class="mx-auto mb-5 p-5 border shadow-sm bg-white rounded-block w-75">
            <div class="top-links">
                <p>
                    <a href="recipes-list.php">Toutes les recettes</a>
                    <span> > </span>
                    <span><?php echo htmlspecialchars($recipe['title'])?></span>
                </p>
                <?php if (isset($isAuthor)): ?>
                <div class="action-btn dropdown">
                    <button class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ...
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end mt-2">
                        <li><a class="dropdown-item" href="#">Modifier</a></li>
                        <li><a class="dropdown-item" href="#">Supprimer</a></li>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
            <?php if ($recipe): ?>
                <h1 class="text-center mb-2"><?php echo htmlspecialchars($recipe['title']) ?></h1>
                <div class="recipe-block_infos text-center mb-3">
                    <p class="recipe-category-label"><?php echo htmlspecialchars($recipe['category_name']) ?></p>
                    <p class="recipe-author">Auteur : <?php echo htmlspecialchars($recipe['user_name'])?></p>
                </div>
                <div class="recipe-block recipe-block_img">
                    <figure class="w-75 text-center m-auto">
                        <img src="<?php echo htmlspecialchars($recipe['illustration'])?>" alt=""/>
                    </figure>
                </div>
                <div class="recipe-block recipe-block_rating">
                    <?php if (isset($recipe['rating'])): ?>
                        <?php echo htmlspecialchars($recipe['rating']) ?>/5
                    <?php else: ?>
                        -/5
                    <?php endif; ?>
                </div>
                <div class="recipe-block recipe-block_description">
                    <div class="recipe-block_description-elt">
                        <h2>
                            <i class="fa-solid fa-plate-wheat"></i>Ingrédients</h2>
                        <p><?php echo htmlspecialchars($recipe['ingredients']) ?></p>
                    </div>
                    <div class="recipe-block_description-elt">
                        <h2>
                            <i class="fa-solid fa-utensils"></i>Ustensiles</h2>
                        <p><?php echo htmlspecialchars($recipe['tools']) ?></p>
                    </div>
                    <div class="recipe-block_description-elt">
                        <h2>
                            <i class="fa-solid fa-fire-burner"></i>Préparation</h2>
                        <p><?php echo htmlspecialchars($recipe['description']) ?></p>
                    </div>
                </div>
            <?php else: ?>
                <p>La recette n'existe pas.</p>
            <?php endif; ?>
        </div>
    </div>
</section>


<?php
$content = ob_get_clean();
require_once (__DIR__ . '/../views/layout.php');
?>