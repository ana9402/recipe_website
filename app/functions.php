<?php
// functions.php


// Redirect to ->
function redirectToUrl(string $url) : never 
{
    header("Location: {$url}");
    exit();
}

///////////////////// RECIPES //////////////////////

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

function getComments($conn, int $recipe_id) : array 
{
    $comments = [];
    $sql = 
        "SELECT comments.*, users.user_id, users.username AS user_username, users.illustration AS user_illustration
        FROM recipes_comments AS comments
        LEFT JOIN users ON comments.user_id = users.user_id
        WHERE comments.recipe_id = ?
        ORDER BY comments.created_at DESC";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $recipe_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    return $comments;
}

function getFavorites($conn, int $recipe_id) : array 
{
    $favorites = [];
    $sql = "SELECT * FROM users_favorites WHERE recipe_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $recipe_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $favorites[] = $row;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    return $favorites;
}