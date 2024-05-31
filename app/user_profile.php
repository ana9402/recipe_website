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
    <div class="container p-5">
        <div class="mx-auto mb-5 p-5 border w-75 bg-white rounded-block">
            <h1 class="text-center">Mon profil</h1>
            <p class="text-center"><?php echo htmlspecialchars(($user['username']))?></p>
            <section id="profile-page" class="d-flex">
                <div class="profile_menu w-25">
                    <ul>
                        <li>
                            <a href="#">Mes informations</a>
                        </li>
                        <li>
                           <a href="#">Mes recettes</a>
                        </li>
                        <li>
                           <a href="#">Mes recettes</a>
                        </li>
                    </ul>
                </div>
                <div class="profile-infos w-75 p-3">
                    test droite
                </div>
            </div>
        </div>
    </div>

</div>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/views/layout.php')
?>