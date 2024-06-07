<?php
// functions.php

require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');

// Redirect to ->
function redirectToUrl(string $url) : never 
{
    header("Location: {$url}");
    exit();
}


// Check if recipe is valid
function isValidRecipe(array $recipe) : bool
{
    if (array_key_exists('is_enabled', $recipe)) {
        $isEnabled = $recipe['is_enabled'];
    } else {
        $isEnabled = false;
    }

    return $isEnabled;
}

// Show author informations
function displayAuthor(string $authorEmail, array $users): string
{
    foreach ($users as $user) {
        if ($authorEmail === $user['email']) {
            return $user['username'];
        }
    }

    return 'Auteur inconnu';
}

function getUserInfos($user_id, $fields = []) {
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

    // Validate fields
    if (empty($fields)) {
        $fields = '*';
    } else {
        $fields = implode(', ', array_map(function($field) {
            return "`$field`";
        }, $fields));
    }

    $sql = "SELECT $fields FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

function getRecipes(array $recipes) : array
{
    $validRecipes = [];

    foreach($recipes as $recipe) {
        if (isValidRecipe($recipe)) {
            $validRecipes[] = $recipe;
        }
    }

    return $validRecipes;
}

// Get user recipes
function getUserRecipes($conn, int $user_id): array
{
    $sql = "SELECT * FROM recipes WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $recipes = [];
    while ($row = $result->fetch_assoc()) {
        if (isValidRecipe($row)) {
            $recipes[] = $row;
        }
    }

    return $recipes;
}

// Check if user is author
function isAuthor(array $current_user, int $author) : bool 
{
    if ($current_user['user_id'] == $author || $current_user['role_id'] == "2") {
        return true;
    } else {
        return false;
    }
}