<?php
require_once (__DIR__ . '/../core/init.php');
require_once (__DIR__ . '/../config/mysql.php');
require_once (__DIR__ . '/../databaseconnect.php');
ob_start();

if (isset($_SESSION['user_id'])) {
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

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_recipes = getUserRecipes($conn, $user_id);

        // Pagination
        $nb_recipes = count($user_recipes);
        $recipesPerPage = 2;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $recipesPerPage;

        $totalPages = ceil($nb_recipes / $recipesPerPage);

        $sql = "SELECT * FROM recipes WHERE user_id = $user_id LIMIT $recipesPerPage;";
        $user_recipes = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

    } else {
        echo "Aucun utilisateur trouvé";
        exit();
    }
}
?>

<div class="bg-login main-container">
    <div class="p-3 p-md-5">
        <div class="container mx-auto p-5 border w-md-75 bg-white rounded-block" id="profile-page">
            <h1 class="text-center">Mon profil</h1>
            <figure>
                <img src="<?php echo htmlspecialchars($user['illustration']); ?>" alt="" />
            </figure>
            <p class="text-center txt-primary"><?php echo htmlspecialchars(($user['username'])) ?></p>
            <div class="row d-flex mt-5">
                <!-- Profile menu -->
                <div class="col-md-3 p-3">
                    <ul class="profile_menu p-3">
                        <li class="profile_menu-link">
                            <a href="#profile-infos" data-tab="profile-infos" class="active"><i
                                    class="fa-solid fa-user"></i>Mes informations</a>
                        </li>
                        <li class="profile_menu-link">
                            <a href="#profile-recipes" data-tab="profile-recipes">
                                <i class="fa-solid fa-bowl-rice"></i>
                                Mes recettes
                            </a>
                        </li>
                        <li class="profile_menu-link">
                            <a href="#profile-favorites" data-tab="profile-favorites">
                                <i class="fa-solid fa-heart"></i>
                                Mes favoris
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Profile content -->
                <div class="col-md-9 p-3">
                    <section class="profile_content active p-3" id="profile-infos">
                        <h2>Mes informations</h2>
                        <form method="post" action="/website_recipe/app/scripts/users/user_edit.php"
                            class="container profile_form">
                            <div class="row">
                                <div class="col-md-6 profile_form-input">
                                    <label for="username" class="form-label">Pseudo *</label>
                                    <input type="input" id="username" name="username" class="form-control"
                                        value="<?php echo htmlspecialchars(($user['username'])) ?>" required>
                                </div>
                                <div class="col-md-6 profile_form-input">
                                    <label for="email" class="form-label">E-mail *</label>
                                    <input type="input" id="email" name="email" class="form-control"
                                        value="<?php echo htmlspecialchars(($user['email'])) ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 profile_form-input">
                                    <label for="firstname" class="form-label">Prénom</label>
                                    <input type="input" id="firstname" name="firstname" class="form-control"
                                        value="<?php echo htmlspecialchars(($user['firstname'])) ?>">
                                </div>
                                <div class="col-md-6 profile_form-input">
                                    <label for="lastname" class="form-label">Nom</label>
                                    <input type="input" id="lastname" name="lastname" class="form-control"
                                        value="<?php echo htmlspecialchars(($user['lastname'])) ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 profile_form-input">
                                    <label for="address" class="form-label">Adresse</label>
                                    <input type="input" id="address" name="address" class="form-control"
                                        value="<?php echo htmlspecialchars(($user['address'])) ?>">
                                </div>
                                <div class="col-md-6 profile_form-input">
                                    <label for="city" class="form-label">Ville</label>
                                    <input type="input" id="city" name="city" class="form-control"
                                        value="<?php echo htmlspecialchars(($user['city'])) ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 profile_form-input">
                                    <label for="zipcode" class="form-label">Code postal</label>
                                    <input type="number" id="zipcode" name="zipcode" class="form-control"
                                        value="<?php echo htmlspecialchars(($user['zipcode'])) ?>">
                                </div>
                                <div class="col-md-6 profile_form-input">
                                    <label for="country" class="form-label">Pays</label>
                                    <input type="input" id="country" name="country" class="form-control"
                                        value="<?php echo htmlspecialchars(($user['country'])) ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 profile_form-input">
                                    <label for="bio" class="form-label">Bio</label>
                                    <textarea id="bio" name="bio" class="form-control" rows="6"><?php echo htmlspecialchars(($user['bio'])) ?></textarea>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="d-block btn btn-primary ms-auto">Enregistrer</button>
                            </div>
                        </form>
                    </section>
                    <section class="p-3 profile_content" id="profile-recipes">
                        <h2>Mes recettes</h2>
                        <div class="row recipe_list d-flex">
                            <?php foreach ($user_recipes as $recipe): ?>
                                <?php require (__DIR__ . '/../views/recipe-thumbnail.php'); ?>
                            <?php endforeach ?>
                            <ul class="pagination mt-4">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php
                                for ($i = 1; $i <= $totalPages; $i++) {
                                    echo '<li class="page-item"><a class="page-link" href="?tab=profile-recipes&?page=' . $i . '">' . $i . '</a></li>';
                                }
                                ?>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </section>
                    <section class="p-3 profile_content" id="profile-favorites">
                        <h2>Mes favoris</h2>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="/website_recipe/app/js/script.js"></script>

<?php
$content = ob_get_clean();
require_once (__DIR__ . '/../views/layout.php')
?>