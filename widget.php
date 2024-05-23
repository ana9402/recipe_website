<!-- widget.php -->
<div class="container">
    <div class="row mb-3">
        <h2>
            Last published recipes
        </h2>
    </div>

    <div class="row recipe_list">
        <?php foreach (getRecipes($recipes) as $recipe) : ?>
            <div class="col-md-4 recipe_thumbnail p-4">
                <h3><?php echo $recipe['title']; ?></h3>
                <h3><?php echo $recipe['user_id']; ?></h3>
                <div><?php echo $recipe['rating']; ?></div>
            </div>
        <?php endforeach ?>
    </div>
</div>