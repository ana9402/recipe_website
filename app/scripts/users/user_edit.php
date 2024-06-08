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


    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $zipcode = isset($_POST['zipcode']) ? $_POST['zipcode'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';
    $bio = isset($_POST['bio']) ? $_POST['bio'] : '';


    $sql = "UPDATE users SET username = ?, email = ?, firstname = ?, lastname = ?, address = ?, city = ?, zipcode = ?, country = ?, bio = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if($stmt) {
        $stmt->bind_param("sssssssssi", $username, $email, $firstname, $lastname, $address, $city, $zipcode, $country, $bio, $user_id);

        $stmt->execute();
        echo "Nombre de lignes affectées: " . $stmt->affected_rows . "<br>";

        if ($stmt->affected_rows > 0) {
            header("Location: /website_recipe/app/pages/user_profile.php");
            exit();
        } else {
            echo "Erreur lors de la modification du profil.";
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