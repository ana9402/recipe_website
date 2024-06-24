<?php
require_once (__DIR__ . '/core/init.php');
$pageTitle = 'Hello';

ob_start();

if (isset($_SESSION["flash"]))
{
    vprintf("<div class='alert alert-success' role='alert' %s>%s</div>", $_SESSION["flash"]);
    unset($_SESSION["flash"]);
}
?>

<div class="main-container">
    <section id="home-hero">
        <div class="container">
            
            <div class="row">
                <h1>Trouver une <span class="txt-primary">recette</span></h1>
            </div>
            <div class="row">
                <form>
                    <input type="text" class="p-3" placeholder="Recherchez un plat, un ingrédient, ...">
                    <button type="submit" class="btn btn-primary btn-searchbar"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"></path>
                </svg></button>
                </form>
            </div>
        </div>
    </section>
    <div class="container p-5">
        <div class="row recipe_list d-flex justify-content-between">
            <?php require_once (__DIR__ . '/views/widget.php') ?>
        </div>
    </div>
</div>


<?php
$content = ob_get_clean();
require_once (__DIR__ . '/views/layout.php');
?>