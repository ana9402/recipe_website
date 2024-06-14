<?php
require_once (__DIR__ . '/../../core/init.php');
require_once(__DIR__ . '/../../config/mysql.php');
require_once(__DIR__ . '/../../databaseconnect.php');

if($_SERVER['REQUEST_METHOD'] == "POST") {

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

    $content = (isset($_POST['comments-new_content'])) ? $_POST['comments-new_content'] : '';
    $recipe_id = (isset($_GET['id'])) ? $_GET['id'] : '';
    $author_id = $_SESSION['user_id'];


    if (empty($content)) {
        echo "Le contenu du commentaire est vide.";
        exit();
    }

    $sql = "INSERT INTO recipes_comments (content, recipe_id, user_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if($stmt) {
        $stmt->bind_param("sii", $content, $recipe_id, $author_id);
        $stmt->execute();

        if($stmt->affected_rows > 0) {
            if (isset($_SERVER['HTTP_REFERER'])) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                header('Location: /website_recipe/app/index.php');
                exit();
            }
        } else {
            echo "Impossible de publier le commentaire.";
        }
        $stmt->close();

    } else {
        echo "Error preparing statement: " . $conn->error;
    }
    $conn->close();

}