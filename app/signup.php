<?php
require_once(__DIR__ . '/core/init.php');
$pageTitle = 'S\'inscrire';

// Définir le contenu de la page
ob_start();
?>

<!-- contenu du site -->
<div class="bg-login">
    <div class="container p-5">
        <div class="mx-auto mb-5 p-5 border w-50 bg-white rounded-block">
            <h1 class="text-center mb-3">S'inscrire</h1>
            <p class="text-center">Créez votre compte.</p>
            <div class="signin-block my-auto p-5">
                <form method="post" action="/login" class="signin-block_form">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex flex-column signin-block_form_input">
                            <label for="login-email" class="form-label visually-hidden">Email *</label>
                            <input type="email" id="login-email" name="login-email" placeholder="Email *" class="form-control">
                        </div>
                        <div class="d-flex flex-column signin-block_form_input">
                            <label for="login-password" class="form-label visually-hidden">Mot de passe *</label>
                            <input type="input" id="login-password" name="login-password" placeholder="Mot de passe *" class="form-control">
                        </div>
                        <div class="d-flex flex-column signin-block_form_input">
                            <label for="login-second_password" class="form-label visually-hidden">Confirmez votre mot de passe *</label>
                            <input type="input" id="login-second_password" name="login-second_password" placeholder="Confirmez votre mot de passe *" class="form-control">
                        </div>
                        <p class="d-flex align-items-start gap-2">
                            <input type="checkbox" id="cgu-validation" name="cgu-validation" class="mt-1">
                            <label for="cgu-validation" class="form-label small">J’accepte les <a href="#">Conditions Générales d'Utilisation</a> et reconnais avoir été informé(e) que mes données personnelles seront utilisées tel que décrit ci-dessous. *</label>
                        </p>
                    </div>
                    <div class="d-flex flex-column align-items-center gap-3 mt-3">
                        <input type="submit" value="S'inscrire" class="btn btn-primary w-75 mx-auto">
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