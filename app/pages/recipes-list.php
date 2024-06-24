<?php
require_once(__DIR__ . '/../core/init.php');
require_once(__DIR__ . '/../config/mysql.php');
require_once(__DIR__ . '/../databaseconnect.php');
require_once(__DIR__ . '/../scripts/recipes/recipes_show.php');
$pageTitle = 'Les recettes';
ob_start();

?>

<!-- Recipes list -->
<section id="recipes-section">
    <div class="container p-5">
        <div class="row mb-3">
            <h1 class="text-center">
                Les recettes
            </h1>
        </div>

        <div class="row recipe_list d-flex justify-content-start">
            <?php $recipes = addPagination();
            foreach ($recipes as $recipe) : ?>
                <?php require (__DIR__ . '/../views/recipe-thumbnail.php'); ?>
            <?php endforeach ?>

            <?php 
                // Gestion de la pagination
                    $page_no = isset($_GET['page_no']) ? (int) $_GET['page_no'] : 1;
                    global $total_no_of_pages, $page_no, $previous_page, $next_page;
                    $adjacents = 2;

                    echo "<nav aria-label='Recipes navigation' class='d-flex justify-content-center'>";
                    echo "<ul class='pagination'>";
                    if ($page_no > 1) {
                        echo "<li class='page-item'><a href='?page_no=$previous_page' class='page-link'>Précédent</a></li>";
                    }

                    for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                        if ($counter == $page_no) {
                            echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                        } else {
                            echo "<li class='page-item'><a href='?page_no=$counter' class='page-link'>$counter</a></li>";
                        }
                    }

                    if ($page_no < $total_no_of_pages) {
                        echo "<li class='page-item'> <a href='?page_no=$next_page' class='page-link'>Suivant</a></li>";
                    }
                    echo "</ul>";
                    echo "</nav>"

            ?>
        </div>
    </div>
</section>


<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../views/layout.php');
?>