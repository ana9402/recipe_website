<?php
require_once(__DIR__ . '/core/init.php');
$pageTitle = 'Se connecter';

// Définir le contenu de la page
ob_start();
?>

<!-- contenu du site -->
<div class="bg-login">
    <div class="container p-5">
        <div class="mx-auto mb-5 p-5 border w-50 bg-white rounded-block">
            <h1 class="text-center mb-3">Se connecter</h1>
            <p class="text-center">Accédez à votre espace.</p>
            <div class="signin-block my-auto p-5">
                <form method="post" action="/login" class="signin-block_form">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex flex-column signin-block_form_input">
                            <label for="login-email" class="form-label visually-hidden">Email</label>
                            <input type="email" id="login-email" name="login-email" placeholder="Email" class="form-control">
                        </div>
                        <div class="d-flex flex-column signin-block_form_input">
                            <label for="login-password" class="form-label visually-hidden">Mot de passe</label>
                            <input type="input" id="login-password" name="login-password" placeholder="Mot de passe" class="form-control">
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
require_once(__DIR__ . '/views/layout.php');
?>