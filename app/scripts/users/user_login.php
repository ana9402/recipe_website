<?php

require_once (__DIR__ . '/../../core/init.php');
require_once(__DIR__ . '/../../config/mysql.php');
require_once(__DIR__ . '/../../databaseconnect.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = 'localhost';
        $dbUsername = 'root';
        $dbPassword = 'root';
        $dbname = 'recipe_website';

        $email = $_POST['login-email'];
        $password = $_POST['login-password'];

        $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

        if ($conn->connect_error) {
            die('Erreur de connexion : ' . $conn->connect_error);
        }

        $stmt = $conn->prepare('SELECT user_id, email, password, role_id FROM users WHERE email = ? AND is_enabled = 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $email, $hashed_password, $role_id);
            $stmt->fetch();
            
            if (password_verify($password, $hashed_password)) {
                // Authentification réussie
                $validPassword = true;

                $_SESSION['user_id'] = $user_id;
                $_SESSION['role'] = $role_id;
                header('Location: /website_recipe/app/index.php');
                exit();
            } else {
                // Mot de passe incorrect
                $validPassword = false;
            }
        } else {
            // Utilisateur non trouvé
            echo 'Erreur, Nom d\'utilisateur ou mot de passe incorrect';
        }

        $stmt->close();
        $conn->close();
    }