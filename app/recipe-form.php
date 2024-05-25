<?php
require_once(__DIR__ . '/core/init.php');
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
$pageTitle = 'Partager une recette';

ob_start();
?>

<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $title = $_REQUEST['title'];
        $ingredients = $_REQUEST['ingredients'];
        $tools = $_REQUEST['ingredients'];
        $prep_time = $_REQUEST['prep-time'];
        $rest_time = $_REQUEST['rest-time'];
        $cook_time = $_REQUEST['cook-time'];
        $servings = $_REQUEST['servings'];
        $description = $_REQUEST['description'];

        $sql = "INSERT INTO recipes (title, ingredients, tools, prep_time, rest_time, cook_time, servings, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $mysqlClient = $mysqlClient->prepare($sql);
        $mysqlClient->execute([$title, $ingredients, $tools, $prep_time, $rest_time, $cook_time, $servings, $description]);

        header("Location: /index.php");
        exit();
    }

?>

<!-- contenu du site -->
<div class="">
    <div class="container p-5">
        <div class="mx-auto mb-5 p-5 border shadow-sm w-75 bg-white rounded-block">
            <h1 class="text-center mb-3">Partager une recette</h1>
            <p class="text-center">Renseignez un maximum d'informations afin d'aider au mieux les utilisateurs.</p>
            <div class="newRecipe-block my-auto p-5">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" class="newRecipe-block_form">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex flex-column newRecipe-block_form_input">
                            <label for="title" class="form-label">Titre de la recette *</label>
                            <input type="input" id="title" name="title" placeholder="" class="form-control" required>
                        </div>
                        <div class="row d-flex flex-row align-items-center gap-3 newRecipe-block_form_input">
                            <label for="category" class="w-auto form-label">Catégorie</label>
                            <select id="category" name="category" placeholder="" class="w-50 form-control">
                                <option value="Entrée">Entrée</option>
                                <option value="Plat">Plat</option>
                                <option value="Dessert">Dessert</option>
                                <option value="Goûter">Goûter</option>
                            </select>
                        </div>
                        <div class="d-flex flex-column newRecipe-block_form_input">
                            <label for="ingredients" class="form-label">Ingrédients *</label>
                            <textarea id="ingredients" name="ingredients" placeholder="Quels sont les ingrédients nécessaires pour réaliser cette recette ?" class="form-control" rows="6" required></textarea>
                        </div>
                        <div class="d-flex flex-column newRecipe-block_form_input">
                            <label for="tools" class="form-label">Ustensiles *</label>
                            <textarea id="tools" name="tools" placeholder="Quels sont les ustensiles nécessaires pour réaliser cette recette ?" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="row newRecipe-block_form_input">
                            <label for="prep-time" class="form-label col-4">Temps de préparation (min)</label>
                            <input type="number" id="prep-time" name="prep-time" placeholder="" class="form-control col-6 w-auto" required>
                        </div>
                        <div class="row newRecipe-block_form_input">
                            <label for="rest-time" class="col-4 form-label">Temps de repos (min)</label>
                            <input type="number" id="rest-time" name="rest-time" placeholder="" class="form-control col-6 w-auto" required>
                        </div>
                        <div class="row newRecipe-block_form_input">
                            <label for="cook-time" class="col-4 form-label">Temps de cuisson (min)</label>
                            <input type="number" id="cook-time" name="cook-time" placeholder="" class="form-control col-6 w-auto" required>
                        </div>
                        <div class="row newRecipe-block_form_input">
                            <label for="servings" class="col-4 form-label">Nombre de parts</label>
                            <input type="number" id="servings" name="servings" placeholder="" class="form-control col-6 w-auto" required>
                        </div>
                        <div class="d-flex flex-column newRecipe-block_form_input">
                            <label for="description" class="form-label">Description *</label>
                            <textarea id="description" name="description" placeholder="Décrivez les étapes de préparation de la recette." class="form-control" rows="6" required></textarea>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-center gap-3 mt-3">
                        <input type="submit" value="Publier" class="btn btn-primary w-75 mx-auto">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/views/layout.php');
?>