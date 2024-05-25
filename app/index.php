<?php
require_once (__DIR__ . '/core/init.php');
$pageTitle = 'Hello';

ob_start();
?>

<div class="main-container">
    <div class="container p-5">
        <h1>Vos inspirations <span class="text-secondary">culinaires</span>.</h1>
        <?php require_once (__DIR__ . '/views/widget.php'); ?>
    </div>
</div>


<?php
$content = ob_get_clean();
require_once (__DIR__ . '/views/layout.php');
?>