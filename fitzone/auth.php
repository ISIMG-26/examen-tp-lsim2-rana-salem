<?php
// auth.php - Page d'authentification (connexion + inscription)
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

$error   = isset($_GET["error"])   ? $_GET["error"]   : "";
$success = isset($_GET["success"]) ? $_GET["success"] : "";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FitZone - Connexion</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<header class="nav">
    <div class="nav-inner">
        <a class="brand" href="index.php">Fit<span>Zone</span></a>
        <nav class="nav-links">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="all.php">Toutes les machines</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li class="sign"><a href="auth.php">Connexion</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="auth-page">
    <div class="auth-box">
        <h1>🌸 Bienvenue !</h1>

        <?php if ($error === "mot_de_passe_incorrect"): ?>
            <p style="color:#c0436e;font-weight:bold;">Mot de passe incorrect.</p>
        <?php elseif ($error === "utilisateur_introuvable"): ?>
            <p style="color:#c0436e;font-weight:bold;">Email introuvable.</p>
        <?php elseif ($error === "email_existe"): ?>
            <p style="color:#c0436e;font-weight:bold;">Cet email est déjà utilisé.</p>
        <?php elseif ($success === "inscription_reussie"): ?>
            <p style="color:#27ae60;font-weight:bold;">Inscription réussie ! Connectez-vous.</p>
        <?php endif; ?>

        <div class="tab-buttons">
            <button class="tab-btn active" data-target="form-login">Connexion</button>
            <button class="tab-btn" data-target="form-register">Inscription</button>
        </div>

        <form id="login-form" class="auth-form active" action="back/login.php" method="POST">
            <label>Email</label>
            <input type="email" id="login-email" name="email" placeholder="votre@email.com" />
            <span class="error-msg" id="login-email-error"></span>

            <label>Mot de passe</label>
            <input type="password" id="login-password" name="password" placeholder="••••••••" />
            <span class="error-msg" id="login-password-error"></span>

            <button type="submit" class="btn-submit">Se connecter</button>
        </form>

        <form id="register-form" class="auth-form" action="back/register.php" method="POST">
            <label>Nom complet</label>
            <input type="text" id="reg-nom" name="nom" placeholder="Votre nom" />
            <span class="error-msg" id="reg-nom-error"></span>

            <label>Email</label>
            <input type="email" id="reg-email" name="email" placeholder="votre@email.com" />
            <span class="error-msg" id="reg-email-error"></span>
            <span id="ajax-result"></span>

            <label>Mot de passe</label>
            <input type="password" id="reg-password" name="password" placeholder="••••••••" />
            <span class="error-msg" id="reg-password-error"></span>

            <label>Confirmer le mot de passe</label>
            <input type="password" id="reg-confirm" name="confirm" placeholder="••••••••" />
            <span class="error-msg" id="reg-confirm-error"></span>

            <button type="submit" class="btn-submit">S'inscrire</button>
        </form>
    </div>
</main>

<footer>
    <hr>
    <div class="nav-inner">
        <a class="brand" href="index.php">Fit<span>Zone</span></a>
    </div>
    <samp>© FitZone. Tous droits réservés.</samp>
</footer>

<script src="js/script.js"></script>
</body>
</html>
