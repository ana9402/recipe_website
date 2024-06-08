<?php
require_once (__DIR__ . '/../../core/init.php');
require_once(__DIR__ . '/../../config/mysql.php');
require_once(__DIR__ . '/../../databaseconnect.php');

if (isset($_SESSION['user_id']) && $_SERVER["REQUEST_METHOD"] == "POST") {

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

    // Check file
    if(isset($_FILES['illustration']) && $_FILES['illustration']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['illustration'];
        $uploadDir = '/Applications/MAMP/htdocs/website_recipe/app/public/user-images';
        $uploadFile =  $uploadDir . '/' . basename($file['name']);

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            $illustration = '/website_recipe/app/public/user-images/' . basename($file['name']);
            echo $illustration;
        } else {
            die("Erreur au téléchargement du fichier.");
        }

    } else {
        die("Erreur de téléchargement : " . $_FILES['illustration']['error']);
    }


    $sql = "UPDATE users SET illustration = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if($stmt) {
        $stmt->bind_param("si", $illustration, $user_id);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: /website_recipe/app/pages/user_profile.php");
            exit();
        } else {
            echo "Le profil n'a pas été mis à jour.";
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

}
else 
{
    header("Location: /website_recipe/app/pages/user_profile.php");
    exit();
}