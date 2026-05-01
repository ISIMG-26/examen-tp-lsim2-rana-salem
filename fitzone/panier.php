<?php
// panier.php - Page panier
session_start();
require_once "back/connexion_db.php";

// Fetch pending cart items (not yet bought)
// We use session to track this user's cart items via IDs stored in session
if (!isset($_SESSION["panier_ids"])) {
    $_SESSION["panier_ids"] = [];
}

$items = [];
if (!empty($_SESSION["panier_ids"])) {
    $ids = implode(",", array_map("intval", $_SESSION["panier_ids"]));
    $result = $conn->query("SELECT * FROM commandes WHERE id IN ($ids) AND statut='panier'");
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FitZone - Mon Panier</title>
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
                <li><a href="panier.php" style="color:#e05c8a;">🛒 Panier <?= !empty($items) ? "(" . count($items) . ")" : "" ?></a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION["user_id"])): ?>
                    <li><span style="color:#6b1d3e;font-weight:bold;">🌸 <?= htmlspecialchars($_SESSION["user_nom"]) ?></span></li>
                    <li class="sign"><a href="back/logout.php">Déconnexion</a></li>
                <?php else: ?>
                    <li class="sign"><a href="auth.php">Connexion</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<main class="panier-page">
    <h1>🛒 Mon Panier</h1>

    <?php if (empty($items)): ?>
        <div class="panier-empty">
            <p>Votre panier est vide.</p>
            <a href="all.php" class="btn-submit" style="display:inline-block;margin-top:20px;width:auto;padding:12px 30px;">Voir les machines</a>
        </div>
    <?php else: ?>

        <div class="panier-list">
            <?php
            $total = 0;
            foreach ($items as $item):
                $total += $item["machine_prix"];
            ?>
            <div class="panier-item" id="item-<?= $item["id"] ?>">
                <div class="panier-item-info">
                    <h3><?= htmlspecialchars($item["machine_nom"]) ?></h3>
                    <p class="panier-prix"><?= number_format($item["machine_prix"], 2) ?> DT</p>
                </div>
                <div class="panier-item-btns">
                    <button class="btn-acheter-item" data-id="<?= $item["id"] ?>">⚡ Acheter</button>
                    <button class="btn-supprimer-item" data-id="<?= $item["id"] ?>">🗑 Retirer</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="panier-total">
            <strong>Total : <span id="panier-total-montant"><?= number_format($total, 2) ?></span> DT</strong>
        </div>

        <button id="btn-acheter-tout" class="btn-acheter-all">⚡ Tout acheter</button>

    <?php endif; ?>
</main>

<!-- ===== MODAL ACHAT ===== -->
<div id="modal-overlay" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <button id="modal-close" class="modal-close">✕</button>
        <h2 id="modal-title">⚡ Finaliser l'achat</h2>
        <p id="modal-machine-name" style="color:#e05c8a;font-weight:bold;margin-bottom:20px;font-size:16px;"></p>

        <div id="modal-form">
            <label>Votre nom *</label>
            <input type="text" id="panier-nom" placeholder="Nom complet" />
            <span class="error-msg" id="panier-nom-error"></span>

            <label>Email *</label>
            <input type="email" id="panier-email" placeholder="votre@email.com" />
            <span class="error-msg" id="panier-email-error"></span>

            <label>Téléphone *</label>
            <input type="tel" id="panier-phone" placeholder="Ex: 23 303 767" />
            <span class="error-msg" id="panier-phone-error"></span>

            <button id="modal-confirm-btn" class="btn-submit" style="margin-top:15px;width:100%;">✅ Confirmer l'achat</button>
        </div>

        <div id="modal-success" style="display:none;text-align:center;padding:20px 0;">
            <p id="modal-success-msg" style="color:#27ae60;font-size:20px;font-weight:bold;"></p>
        </div>
    </div>
</div>
<!-- ===== FIN MODAL ===== -->

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
<?php $conn->close(); ?>
