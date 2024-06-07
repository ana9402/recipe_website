<?php
require_once (__DIR__ . '/../core/init.php');
require_once(__DIR__ . '/../config/mysql.php');
require_once(__DIR__ . '/../databaseconnect.php');

if (isset($_POST['recipeId']))
{
    try {
        $id = $_POST['recipeId'];
        $deleteRecipeStatement = $mysqlClient->prepare('DELETE FROM recipes WHERE id = :id');
        $deleteRecipeStatement->execute([
            'id' => $id
        ]);

        header('Location: /website_recipe/app/index.php');
        exit();
    } 
    catch (Exception $e) {
        echo 'Erreur lors de la suppression de la recette : ' . $e->getMessage();
    }
} else {
    echo 'Impossible de récupérer l\'id de la recette';
}
