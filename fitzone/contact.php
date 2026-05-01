<?php
// contact.php - Page de contact
session_start();

$success = isset($_GET["success"]) ? $_GET["success"] : "";
$error   = isset($_GET["error"])   ? $_GET["error"]   : "";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FitZone - Contact</title>
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
                <?php if (isset($_SESSION["user_id"])): ?>
                    <li class="sign"><a href="back/logout.php">Déconnexion</a></li>
                <?php else: ?>
                    <li class="sign"><a href="auth.php">Connexion</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<main class="contact-page">
    <h1>📩 Contactez-nous</h1>

    <?php if ($success === "message_envoye"): ?>
        <p style="color:#27ae60;font-weight:bold;margin-bottom:20px;">✅ Message envoyé avec succès !</p>
    <?php elseif ($error): ?>
        <p style="color:#c0436e;font-weight:bold;margin-bottom:20px;">❌ Erreur lors de l'envoi.</p>
    <?php endif; ?>

    <form id="contact-form" class="contact-form" action="back/contact_send.php" method="POST">
        <label>Nom complet</label>
        <input type="text" id="contact-nom" name="nom" placeholder="Votre nom" />
        <span class="error-msg" id="contact-nom-error"></span>

        <label>Email</label>
        <input type="email" id="contact-email" name="email" placeholder="votre@email.com" />
        <span class="error-msg" id="contact-email-error"></span>

        <label>Message</label>
        <textarea id="contact-message" name="message" placeholder="Votre message..."></textarea>
        <span class="error-msg" id="contact-message-error"></span>

        <button type="submit" class="btn-contact">Envoyer 🌸</button>
    </form>
</main>

<footer>
    <hr>
    <div class="nav-inner">
        <a class="brand" href="index.php">Fit<span>Zone</span></a>
        <nav class="nav-links">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="all.php">Toutes les machines</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </div>
    <samp>© FitZone. Tous droits réservés.<br>Email: fitzone@shop.tn &nbsp;|&nbsp; Tel: 23 303 767</samp>
</footer>

<script src="js/script.js"></script>
</body>
</html>
