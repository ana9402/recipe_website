<?php
require_once (__DIR__ . '/../../core/init.php');
require_once(__DIR__ . '/../../config/mysql.php');
require_once(__DIR__ . '/../../databaseconnect.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['commentId']))
{
    try {
        $id = $_POST['commentId'];
        $deleteCommentStatement = $mysqlClient->prepare('DELETE FROM recipes_comments WHERE id = :id');
        $deleteCommentStatement->execute([
            'id' => $id
        ]);

        if ($deleteCommentStatement->rowCount() > 0) {
            // Suppression réussie
            if (isset($_SERVER['HTTP_REFERER'])) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                header('Location: /website_recipe/app/index.php');
            }
            exit();
        } else {
            // Aucune ligne supprimée
            echo 'Aucun commentaire supprimé.';
        }
    } 
    catch (Exception $e) {
        echo 'Erreur lors de la suppression du commentaire : ' . $e->getMessage();
    }
} else {
    echo 'Impossible de récupérer l\'id du commentaire';
}
