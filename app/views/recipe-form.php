<?php
require_once(__DIR__ . '/../core/init.php');
require_once(__DIR__ . '/../config/mysql.php');
require_once(__DIR__ . '/../databaseconnect.php');

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

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = 'SELECT recipes.*, categories.name AS category_name, users.username as user_name
            FROM recipes
            LEFT JOIN categories ON recipes.category_id = categories.id
            LEFT JOIN users ON recipes.user_id = users.user_id
            WHERE recipes.id = ?';
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
        
            if($result->num_rows > 0) {
                $recipe = $result->fetch_assoc();
            } else {
                echo "Aucune recette trouvée";
                exit();
            }
        }

        $formAction = '/website_recipe/app/scripts/recipes/recipe_edit.php?id=' . $id;
    } else {
        $formAction = '/website_recipe/app/scripts/recipes/recipe_create.php';
    }

    if(!isset($_SESSION['user_id']))
    {
        header('Location: login.php');
        exit();
    }

?>
   <div class="container p-5">
        <div class="mx-auto mb-5 p-5 border shadow-sm w-75 bg-white rounded-block">
            <h1 class="text-center mb-3"><i class="fa-solid fa-spoon me-2 text-secondary"></i> Partager une recette</h1>
            <p class="text-center mb-5">Renseignez un maximum d'informations afin d'aider au mieux les utilisateurs dans l'élaboration de votre recette.</p>
            <div class="newRecipe-block my-auto">
                <form method="post" enctype="multipart/form-data" action="<?php echo $formAction ?>" class="newRecipe-block_form">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex flex-column newRecipe-block_form_input">
                            <label for="title" class="form-label">Titre de la recette *</label>
                            <input type="input" id="title" name="title" placeholder="" class="form-control" value="<?php echo (isset($_GET['id'])) ? htmlspecialchars($recipe['title']) : ''; ?>" required>

                        </div>
                        <div class="row d-flex flex-row align-items-center gap-3 newRecipe-block_form_input">
                            <label for="category" class="w-auto form-label">Catégorie *</label>
                            <select id="category" name="category" placeholder="" class="w-50 form-select" aria-label="Category selection">
                                <option selected>Sélectionnez une catégorie</option>
                                <option value="1">Entrée</option>
                                <option value="2">Plat principal</option>
                                <option value="3">Dessert</option>
                                <option value="4">Accompagnement</option>
                                <option value="5">Amuse-bouche</option>
                                <option value="6">Boisson</option>
                                <option value="7">Confiserie</option>
                                <option value="8">Sauce</option>
                                <option value="9">Pain & boulangerie</option>
                            </select>
                        </div>
                        <div class="d-flex flex-column newRecipe-block_form_input">
                            <label for="ingredients" class="form-label">Ingrédients *</label>
                            <textarea id="ingredients" name="ingredients" placeholder="Quels sont les ingrédients nécessaires pour réaliser cette recette ?" class="form-control" rows="6" required><?php echo (isset($_GET['id'])) ? htmlspecialchars(($recipe['ingredients'])) : ''; ?></textarea>
                        </div>
                        <div class="d-flex flex-column newRecipe-block_form_input">
                            <label for="tools" class="form-label">Ustensiles *</label>
                            <textarea id="tools" name="tools" placeholder="Quels sont les ustensiles nécessaires pour réaliser cette recette ?" class="form-control" rows="4" required><?php echo (isset($_GET['id'])) ? htmlspecialchars(($recipe['tools'])) : ''; ?></textarea>
                        </div>
                        <div class="row newRecipe-block_form_input">
                            <label for="prep-time" class="form-label col-4">Temps de préparation (min)</label>
                            <input type="number" id="prep-time" name="prep-time" placeholder="" class="form-control col-6 w-auto" value="<?php echo (isset($_GET['id'])) ? htmlspecialchars($recipe['prep_time']) : ''; ?>">
                        </div>
                        <div class="row newRecipe-block_form_input">
                            <label for="rest-time" class="col-4 form-label">Temps de repos (min)</label>
                            <input type="number" id="rest-time" name="rest-time" placeholder="" class="form-control col-6 w-auto" value="<?php echo (isset($_GET['id'])) ? htmlspecialchars($recipe['rest_time']) : ''; ?>">
                        </div>
                        <div class="row newRecipe-block_form_input">
                            <label for="cook-time" class="col-4 form-label">Temps de cuisson (min)</label>
                            <input type="number" id="cook-time" name="cook-time" placeholder="" class="form-control col-6 w-auto" value="<?php echo (isset($_GET['id'])) ? htmlspecialchars($recipe['cook_time']) : ''; ?>">
                        </div>
                        <div class="row newRecipe-block_form_input">
                            <label for="servings" class="col-4 form-label">Nombre de parts *</label>
                            <input type="number" id="servings" name="servings" placeholder="" class="form-control col-6 w-auto" value="<?php echo (isset($_GET['id'])) ? htmlspecialchars($recipe['servings']) : ''; ?>" required>
                        </div>
                        <div class="d-flex flex-column newRecipe-block_form_input">
                            <label for="description" class="form-label">Préparation *</label>
                            <textarea id="description" name="description" placeholder="Décrivez les étapes de préparation de la recette." class="form-control" rows="6" required><?php echo (isset($_GET['id'])) ? htmlspecialchars(($recipe['servings'])) : ''; ?></textarea>
                        </div>
                        <div class="newRecipe-block_form_input">
                            <label for="image" class="form-label">Illustration *</label>
                            <input type="file" id="illustration" name="illustration" class="form-control" required></i>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-center gap-3 mt-3">
                        <input type="submit" class="btn btn-primary w-75 mx-auto" value="Publier">
                        </i>
                    </div>
                </form>
            </div>
        </div>
    </div>