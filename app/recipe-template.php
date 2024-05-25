<?php

require_once (__DIR__ . '/core/init.php');
require_once (__DIR__ . '/config/mysql.php');
require_once (__DIR__ . '/databaseconnect.php');
$pageTitle = 'Recette';

ob_start();

$id = $_GET['id'];
$sql = 'SELECT * from recipes WHERE id = :id';
$stmt = $mysqlClient->prepare($sql);
$stmt->execute(['id' => $id]);
$recipe = $stmt->fetch();
?>

<section id="recipeTemplate-section">
    <div class="container p-5">
        <div class="mx-auto mb-5 p-5 border shadow-sm bg-white rounded-block">
            <?php if ($recipe): ?>
                <h1 class="text-center mb-5"><?php echo htmlspecialchars($recipe['title']) ?></h1>
                <p>
                    <?php if (isset($recipe['rating'])): ?>
                        <?php echo htmlspecialchars($recipe['rating']) ?>/5
                    <?php else: ?>
                        -/5
                    <?php endif; ?>
                </p>
                <div>
                    <h2>Ingrédients</h2>
                    <p><?php echo htmlspecialchars($recipe['ingredients']) ?></p>
                </div>
                <div>
                    <h2>Ustensiles</h2>
                    <p><?php echo htmlspecialchars($recipe['tools']) ?></p>
                </div>
                <div>
                    <h2>Préparation</h2>
                    <p><?php echo htmlspecialchars($recipe['description']) ?></p>
                </div>
            <?php else: ?>
                <p>La recette n'existe pas.</p>
            <?php endif; ?>
        </div>
    </div>
</section>


<?php
$content = ob_get_clean();
require_once (__DIR__ . '/views/layout.php');
?>