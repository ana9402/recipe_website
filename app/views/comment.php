<?php
require_once(__DIR__ . '/../core/init.php');
require_once(__DIR__ . '/../config/mysql.php');
require_once(__DIR__ . '/../databaseconnect.php');

$isAuthor = (isset($_SESSION['user_id']) &&  $_SESSION['user_id'] == $comment['user_id'] ? true : false);

?>

<div class="mb-3 comment-block row">
    <div class="comment-block_avatar col-auto">
        <figure class="user-avatar">
            <img src="<?php echo htmlspecialchars($comment['user_illustration'])?>" alt="" />
        </figure>
    </div>
    <div class="comment-block_infos col">
        <div class="comment-content-row d-flex">
            <div class="comment-block_infos-username"><?php echo htmlspecialchars($comment['user_username']) . ' -';?></div>
            <div class="ms-1">Créé le <?php echo htmlspecialchars($comment['created_at']);?></div>
            <?php if($isAuthor == true): ?>
                <div class="comment-block_infos-actions dropdown">
                    <button class="" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                    <ul class="dropdown-menu dropdown-menu-end mt-2">
                        <li><a class="dropdown-item" href="#">Modifier</a></li>
                        <li><a class="dropdown-item" href="#" onclick="confirmDeletion(<?php echo htmlspecialchars($comment['id']) ?>, event, 'Êtes-vous sûr(e) de vouloir supprimer ce commentaire ?', 'deleteCommentForm')">Supprimer</a></li>
                        <form id="deleteCommentForm" method="post" action="/website_recipe/app/scripts/comments/comment_delete.php" style="display: none;">
                                <input type="hidden" name="commentId" id="commentId" value="<?php echo htmlspecialchars($comment['id']) ?>">
                        </form>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        <div class="comment-content-row"><?php echo $comment['content']?></div>
        <div class="comment-content-row comment-content-bottom">
            <span><i class="fa-regular fa-heart"></i> Likes</span>
        </div>
    </div>
</div>