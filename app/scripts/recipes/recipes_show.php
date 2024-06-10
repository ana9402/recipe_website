<?php
require_once (__DIR__ . '/../../core/init.php');
require_once(__DIR__ . '/../../config/mysql.php');
require_once(__DIR__ . '/../../databaseconnect.php');

function addPagination() : array 
{

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

    global $total_no_of_pages, $page_no, $previous_page, $next_page, $total_records;

    $page_no = isset($_GET['page_no']) ? (int)$_GET['page_no'] : 1;

    $total_records_per_page = 12; // Nombre de recettes par page
    $offset = ($page_no - 1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;

    $offset = ($page_no-1) * $total_records_per_page;

    $result_count_stmt = $conn->prepare("SELECT COUNT(*) AS total_records FROM recipes");
    $result_count_stmt->execute();
    $result_count_stmt->bind_result($total_records);
    $result_count_stmt->fetch();
    $result_count_stmt->close();

    $total_no_of_pages = ceil($total_records / $total_records_per_page);

    $result_stmt = $conn->prepare("SELECT * FROM recipes LIMIT ?, ?");
    $result_stmt->bind_param("ii", $offset, $total_records_per_page);
    $result_stmt->execute();
    $result = $result_stmt->get_result();
    
    $recipes = [];

    while ($recipe = $result->fetch_assoc()) {
        $recipes[] = $recipe;
    }

    $result_stmt->close();
    $conn->close();

    // Return the collected recipes array
    return $recipes;
}