<?php
// all.php - Page "Toutes les machines" + Panier intégré
session_start();
require_once "back/connexion_db.php";

$result = $conn->query("SELECT id, nom, categorie, prix, image FROM machines ORDER BY categorie");

$machines_par_categorie = [];
while ($row = $result->fetch_assoc()) {
    $machines_par_categorie[$row["categorie"]][] = $row;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FitZone - Toutes les machines</title>
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
                <li><a href="panier.php" style="color:#e05c8a;">🛒 Panier</a></li>
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

<hr />

<!-- Barre de recherche AJAX -->
<div class="search-bar">
    <h2 style="color:#6b1d3e;margin-bottom:15px;">Rechercher une machine</h2>
    <input type="text" id="search-input" placeholder="🔍 Tapez le nom d'une machine..." />
    <div id="search-results" style="max-width:500px;margin:10px auto;text-align:left;"></div>
</div>

<section>
    <div class="part3">
        <h1><span>TOUTES</span> NOS MACHINES</h1>

        <?php foreach ($machines_par_categorie as $categorie => $machines): ?>
        <div class="cards3">
            <h1><?= htmlspecialchars($categorie) ?> :</h1>
            <?php foreach ($machines as $machine): ?>
            <article>
                <img src="images/<?= htmlspecialchars($machine['image']) ?>" class="image" alt="<?= htmlspecialchars($machine['nom']) ?>" />
                <h3><?= htmlspecialchars($machine['nom']) ?></h3>
                <p style="color:#e05c8a;font-weight:bold;"><?= htmlspecialchars($machine['prix']) ?> DT</p>
                <!-- Bouton panier -->
                <div class="machine-btns">
                    <button class="btn-panier" 
                        data-id="<?= $machine['id'] ?>"
                        data-nom="<?= htmlspecialchars($machine['nom']) ?>">
                        🛒 Ajouter au panier
                    </button>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>

    </div>
</section>

<!-- Toast notification -->
<div id="toast" style="display:none;position:fixed;bottom:30px;right:30px;background:#27ae60;color:#fff;padding:14px 24px;border-radius:12px;font-weight:bold;font-size:16px;z-index:9999;box-shadow:0 4px 15px rgba(0,0,0,.3);"></div>

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
