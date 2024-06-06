<?php
    require_once(__DIR__ . '/../core/init.php');
    require_once(__DIR__ . '/../config/mysql.php');
    require_once(__DIR__ . '/../databaseconnect.php');
    $pageTitle = 'Se connecter';
    /*
    session_start();*/
    // Définir le contenu de la page
    ob_start();

    if(isset($_SESSION['user_id'])) 
    {
        header('Location: ../index.php');
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = 'localhost';
        $dbUsername = 'root';
        $dbPassword = 'root';
        $dbname = 'recipe_website';

        $email = $_POST['login-email'];
        $password = $_POST['login-password'];

        $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

        if ($conn->connect_error) {
            die('Erreur de connexion : ' . $conn->connect_error);
        }

        $stmt = $conn->prepare('SELECT user_id, email, password FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $email, $hashed_password);
            $stmt->fetch();
            
            if (password_verify($password, $hashed_password)) {
                // Authentification réussie
                $validPassword = true;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['email'] = $email;
                header('Location: ../index.php');
                exit();
            } else {
                // Mot de passe incorrect
                $validPassword = false;
            }
        } else {
            // Utilisateur non trouvé
            echo 'Erreur, Nom d\'utilisateur ou mot de passe incorrect';
        }

        $stmt->close();
        $conn->close();
    }
?>

<!-- contenu du site -->
<div class="bg-login">
    <div class="container p-5">
        <div class="mx-auto mb-5 p-5 border w-50 bg-white rounded-block">
            <h1 class="text-center mb-3">Se connecter</h1>
            <p class="text-center">Accédez à votre espace.</p>
            <div class="signin-block my-auto p-5">
                <form method="post" action="login.php" class="signin-block_form">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex flex-column signin-block_form_input">
                            <label for="login-email" class="form-label visually-hidden">Email</label>
                            <input type="email" id="login-email" name="login-email" placeholder="Email" class="form-control">
                        </div>
                        <div class="d-flex flex-column signin-block_form_input">
                            <label for="login-password" class="form-label visually-hidden">Mot de passe</label>
                            <input type="password" id="login-password" name="login-password" placeholder="Mot de passe" class="form-control">
                            <p class="small text-end mt-3"><a href="#">Mot de passe oublié ?</a></p>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-center gap-3 mt-3">
                        <input type="submit" value="Se connecter" class="btn btn-primary w-75 mx-auto">
                        <p class="text-center mb-0">ou</p>
                        <a href="signup.php" class="btn btn-secondary w-75 mx-auto">Créer un compte</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once(__DIR__ . '/../views/layout.php');
?>