<?php
    require_once (__DIR__ . '/core/init.php');
    require_once (__DIR__ . '/config/mysql.php');
    require_once (__DIR__ . '/databaseconnect.php');
    ob_start();

    if(isset($_SESSION['user_id'])) {
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
        $sql = "SELECT * FROM users WHERE user_id = $user_id";
        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        }
    }
?>

<div class="bg-login main-container">
    <div class="p-3 p-md-5">
        <div class="container mx-auto p-5 border w-md-75 bg-white rounded-block">
            <h1 class="text-center">Mon profil</h1>
            <p class="text-center"><?php echo htmlspecialchars(($user['username']))?></p>
            <section id="profile-page" class="row d-flex">
                <div class="col-md-3 profile_menu">
                    <ul>
                        <li>
                            <a href="#">Mes informations</a>
                        </li>
                        <li>
                           <a href="#">Mes recettes</a>
                        </li>
                        <li>
                           <a href="#">Mes favoris</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9
                 profile-infos p-3">
                    <div class="p-2 m-2">
                        <h2 class="mb-4">Mes informations</h2>
                        <form method="get" action="" class="container profile_form">
                            <div class="row">
                                <div class="col-md-6 profile_form-input">
                                    <label for="username" class="form-label">Pseudo *</label>
                                    <input type="input" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars(($user['username']))?>" required>
                                </div>
                                <div class="col-md-6 profile_form-input">
                                    <label for="email" class="form-label">E-mail *</label>
                                    <input type="input" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars(($user['email']))?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 profile_form-input">
                                    <label for="firstname" class="form-label">Prénom</label>
                                    <input type="input" id="firstname" name="firstname" class="form-control" value="<?php echo htmlspecialchars(($user['firstname']))?>">
                                </div>
                                <div class="col-md-6 profile_form-input">
                                    <label for="lastname" class="form-label">Nom</label>
                                    <input type="input" id="lastname" name="lastname" class="form-control" value="<?php echo htmlspecialchars(($user['lastname']))?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 profile_form-input">
                                    <label for="address" class="form-label">Adresse</label>
                                    <input type="input" id="address" name="address" class="form-control" value="<?php echo htmlspecialchars(($user['address']))?>">
                                </div>
                                <div class="col-md-6 profile_form-input">
                                    <label for="city" class="form-label">Ville</label>
                                    <input type="input" id="city" name="city" class="form-control" value="<?php echo htmlspecialchars(($user['city']))?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 profile_form-input">
                                    <label for="zipcode" class="form-label">Code postal</label>
                                    <input type="input" id="zipcode" name="zipcode" class="form-control" value="<?php echo htmlspecialchars(($user['zipcode']))?>">
                                </div>
                                <div class="col-md-6 profile_form-input">
                                    <label for="country" class="form-label">Pays</label>
                                    <input type="input" id="country" name="country" class="form-control" value="<?php echo htmlspecialchars(($user['country']))?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 profile_form-input">
                                    <label for="bio" class="form-label">Bio</label>
                                    <textarea id="bio" name="bio" class="form-control" rows="6" value="<?php echo htmlspecialchars(($user['bio']))?>"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/views/layout.php')
?>