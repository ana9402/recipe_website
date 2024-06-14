<?php
require_once(__DIR__ . '/../core/init.php');
require_once(__DIR__ . '/../config/mysql.php');
require_once(__DIR__ . '/../databaseconnect.php');

?>

<div class="col-md-3 comment-block">
    <div><?php echo $comment['content']?></div>
</div>