<?php
require_once (__DIR__ . '/core/init.php');
$pageTitle = 'Hello';

ob_start();
?>

<div class="container">
    <h1>Vos inspirations <span class="text-primary">culinaires</span>.</h1>
    <?php require_once (__DIR__ . '/views/widget.php'); ?>
</div>

<?php
$content = ob_get_clean();
require_once (__DIR__ . '/views/layout.php');
?>