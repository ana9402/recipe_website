<?php
require_once(__DIR__ . '/../core/init.php');
require_once(__DIR__ . '/../config/mysql.php');
require_once(__DIR__ . '/../databaseconnect.php');

$sql = "SELECT * from recipes";
$stmt = $mysqlClient->query($sql);

$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC)

?>

<div class="col-md-3 recipe-thumbnail">
    <a href="recipe-template.php?id=<?php echo htmlspecialchars($recipe['id'])?>">
        <figure class="recipe-thumbnail_img">
            <img src="<?php echo $recipe['illustration']?>"/>
        </figure>
        <div class="recipe-thumbnail_bottom p-3">
            <h3><?php echo $recipe['title']; ?></h3>
        </div>
        
    </a>
</div>