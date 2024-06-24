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

    $user_id = intval($_POST['user_id']);
    $recipe_id = intval($_POST['recipe_id']);


    $getFavorites = "SELECT * FROM users_favorites WHERE user_id = ? AND recipe_id = ?";

    $stmt = $conn->prepare($getFavorites);
    $stmt->bind_param("ii", $user_id, $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        
        $sql = "DELETE FROM users_favorites WHERE user_id = ? AND recipe_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $recipe_id);
        $stmt->execute();
        exit();

    } else {
        $sql = "INSERT INTO users_favorites (user_id, recipe_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        if($stmt) {
            $stmt->bind_param("ii", $user_id, $recipe_id);
            $stmt->execute();
    
            if($stmt->affected_rows > 0) {
                exit();
            } else {
                echo "Impossible d'ajouter la recette en favoris'";
            }
            $stmt->close();
    
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
            
    }

}