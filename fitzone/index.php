<?php
// index.php - Page d'accueil
session_start();
require_once "back/connexion_db.php";

$result = $conn->query("SELECT id, nom, categorie, image FROM machines LIMIT 3");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FitZone - Accueil</title>
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
                <li><a href="contact.php" class="btn_c">Contact</a></li>
                <?php if (isset($_SESSION["user_id"])): ?>
                    <li><span style="color:#6b1d3e;font-weight:bold;">Bonjour, <?= htmlspecialchars($_SESSION["user_nom"]) ?> 🌸</span></li>
                    <li class="sign"><a href="back/logout.php">Déconnexion</a></li>
                <?php else: ?>
                    <li class="sign"><a href="auth.php">Connexion</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<main>
    <div class="part1">
        <img src="images/image1.png" alt="FitZone Banner" />
    </div>

    <div class="part2">
        <h1><span>SETTING</span> THE STANDARDS</h1>
        <p id="welcome-message" style="color:#f9c6d8; margin-bottom:20px;"></p>
        <div class="cards">
            <article>
                <img src="images/image2.png" alt="Mr Olympia" />
                <h3>Mr. Olympia</h3>
                <h2>Title Sponsors</h2>
                <p>FitZone est le sponsor officiel de Mr. Olympia, gage de qualité professionnelle.</p>
            </article>
            <article>
                <img src="images/image3.png" alt="Qualité Premium" />
                <h3>Premium</h3>
                <h2>Qualité</h2>
                <p>Nos équipements sont fabriqués avec des matériaux haut de gamme pour durer.</p>
            </article>
            <article>
                <img src="images/image4.png" alt="Pour les sportifs" />
                <h3>Conçu pour</h3>
                <h2>Les Sportifs</h2>
                <p>Chaque machine est pensée pour offrir une expérience d'entraînement optimale.</p>
            </article>
        </div>
    </div>
</main>

<section>
    <div class="part3">
        <h1><span>NOS</span> MACHINES</h1>
        <div class="cards2" style="display:flex;justify-content:center;gap:30px;flex-wrap:wrap;">
            <?php while ($row = $result->fetch_assoc()): ?>
            <article style="text-align:center;padding:15px;">
                <img src="images/<?= htmlspecialchars($row['image']) ?>" class="image" alt="<?= htmlspecialchars($row['nom']) ?>" />
                <h3 style="color:#6b1d3e;margin-top:10px;"><?= htmlspecialchars($row['nom']) ?></h3>
                <p style="color:#e05c8a;font-size:14px;"><?= htmlspecialchars($row['categorie']) ?></p>
            </article>
            <?php endwhile; ?>
        </div>
        <div class="view-all"><a href="all.php">Voir tout</a></div>
    </div>
</section>

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
