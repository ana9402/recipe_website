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

    $title = (isset($_POST['title'])) ? $_POST['title'] : '' ;
    $category_id = (isset($_POST['category'])) ? $_POST['category'] : '';
    $ingredients = (isset($_POST['ingredients'])) ? $_POST['ingredients'] : '';
    $tools = (isset($_POST['tools'])) ? $_POST['tools'] : '';
    $prep_time = (isset($_POST['prep-time'])) ? $_POST['prep-time'] : '';
    $rest_time = (isset($_POST['rest-time'])) ? $_POST['rest-time'] : '';
    $cook_time = (isset($_POST['cook-time'])) ? $_POST['cook-time'] : '';
    $servings = (isset($_POST['servings'])) ? $_POST['servings'] : '';
    $description = (isset($_POST['description'])) ? $_POST['description'] : '';
    $author = $_SESSION['user_id'];

    // Check file
    if(isset($_FILES['illustration']) && $_FILES['illustration']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['illustration'];
        $uploadDir = '/Applications/MAMP/htdocs/website_recipe/app/public/recipe-images';
        $uploadFile =  $uploadDir . '/' . basename($file['name']);

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            $illustration = '/website_recipe/app/public/recipe-images/' . basename($file['name']);
        } else {
            die("Erreur au téléchargement du fichier.");
        }

    } else {
        die("Erreur de téléchargement : " . $_FILES['illustration']['error']);
    }


    $sql = "INSERT INTO recipes (title, category_id, ingredients, tools, prep_time, rest_time, cook_time, servings, description, illustration, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sissiiiissi", $title, $category_id, $ingredients, $tools, $prep_time, $rest_time, $cook_time, $servings, $description, $illustration, $author);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION["flash"] = ["type" => "success", "message" => "La recette a bien été publiée."];
            header("Location: /website_recipe/app/index.php");
            exit();
        } else {
            echo "Impossible de publier la recette";
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

}