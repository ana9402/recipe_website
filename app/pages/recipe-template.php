<?php
require_once (__DIR__ . '/../core/init.php');
require_once (__DIR__ . '/../config/mysql.php');
require_once (__DIR__ . '/../databaseconnect.php');
require_once (__DIR__ . '/../functions.php');
require_once (__DIR__ . '/../scripts/comments/comment_create.php');

$pageTitle = 'Recette';

ob_start();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "recipe_website";

// DB connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'];
$sql = 'SELECT recipes.*, categories.name AS category_name, users.username as user_name
        FROM recipes
        LEFT JOIN categories ON recipes.category_id = categories.id
        LEFT JOIN users ON recipes.user_id = users.user_id
        WHERE recipes.id = :id';
$stmt = $mysqlClient->prepare($sql);
$stmt->execute(['id' => $id]);
$recipe = $stmt->fetch();

$comments = getComments($conn, $recipe['id']);

if(isset($_SESSION['user_id']) && $recipe['user_id'] == $_SESSION['user_id']) 
{
    $isAuthor = true;
} else {
    $isAuthor = false;
}

?>

<div id="recipeTemplate-section">
    <div class="container p-5">
        <section class="mx-auto mb-5 p-5 border shadow-sm bg-white rounded-block w-75">
            <div class="top-links">
                <p>
                    <a href="recipes-list.php">Toutes les recettes</a>
                    <span> > </span>
                    <span><?php echo htmlspecialchars($recipe['title'])?></span>
                </p>
                <?php if ((isset($isAuthor) && $isAuthor === true) || (isset($_SESSION['role']) && $_SESSION['role'] == 2)): ?>
                <div class="action-btn dropdown">
                    <button class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ...
                    </button>
                    <div class="dropdown-menu dropdown-menu-end mt-2">
                        <li><a class="dropdown-item" href="http://localhost:8888/website_recipe/app/pages/recipe-edition.php?id=<?php echo htmlspecialchars($recipe['id'])?>">Modifier</a></li>
                        <li><a class="dropdown-item" href="#" onclick="confirmDeletion(<?php echo $id ?>, event, 'Êtes-vous sûr(e) de vouloir supprimer cette recette ?', 'deleteRecipeForm')">Supprimer</a></li>
                        <form id="deleteRecipeForm" method="post" action="/website_recipe/app/scripts/recipes/recipe_delete.php" style="display: none;">
                                <input type="hidden" name="recipeId" id="recipeId">
                        </form>
                    </div>
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
                <div class="row justify-content-center recipe-block px-5">
                    <div class="col-auto recipe-like"><a href="#" onclick="addToFavorite(<?php echo htmlspecialchars($user_id) ?>, <?php echo htmlspecialchars($id) ?>); return false;"><i class="fa-regular fa-heart"></i></a> favoris</div>
                    <div class="col-auto"><i class="fa-regular fa-message"></i> commentaires</div>
                    <div class="col-auto"><i class="fa-solid fa-share-nodes"></i> partages</div>
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
                        <p><?php echo nl2br(htmlspecialchars($recipe['ingredients'])) ?></p>
                    </div>
                    <div class="recipe-block_description-elt">
                        <h2>
                            <i class="fa-solid fa-utensils"></i>Ustensiles</h2>
                        <p><?php echo nl2br(htmlspecialchars($recipe['tools'])) ?></p>
                    </div>
                    <div class="recipe-block_description-elt">
                        <h2>
                            <i class="fa-solid fa-fire-burner"></i>Préparation</h2>
                        <p><?php echo nl2br(htmlspecialchars($recipe['description'])) ?></p>
                    </div>
                </div>
            <?php else: ?>
                <p>La recette n'existe pas.</p>
            <?php endif; ?>
        </section>
        <section class="mx-auto mb-5 p-5 border shadow-sm bg-white rounded-block w-75">
                <h2>Commentaires (<?php echo count($comments); ?>)</h2>
                <div>
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <form method="post" action="/website_recipe/app/scripts/comments/comment_create.php?id=<?php echo htmlspecialchars($id) ?>" id="comments-new">
                        <textarea id="comments-new_content" name="comments-new_content" rows="5" placeholder="Rédigez un commentaire" required></textarea>
                        <button type="submit" form="comments-new" value="Publier" id="comments-new_btn" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i></button>
                    </form>
                    <?php endif;  ?>
                    <div id="comments-list">
                        <?php 
                            if(!empty($comments)) {
                                foreach ($comments as $comment) {
                                    require (__DIR__ . '/../views/comment.php');
                                }
                            } else {
                                echo "<p>Aucun commentaire n'a été publié pour le moment.</p>";
                            }
                        ?>
                    </div>
                </div>
        </section>
    </div>
</div>

<script src="/website_recipe/app/js/script.js"></script>

<?php
$content = ob_get_clean();
require_once (__DIR__ . '/../views/layout.php');
?>