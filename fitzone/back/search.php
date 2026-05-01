<?php
// back/search.php - AJAX search handler
require_once "connexion_db.php";

$q = isset($_GET["q"]) ? "%" . trim($_GET["q"]) . "%" : "%";

$stmt = $conn->prepare("SELECT nom, categorie, prix FROM machines WHERE nom LIKE ? LIMIT 10");
$stmt->bind_param("s", $q);
$stmt->execute();
$result = $stmt->get_result();

$machines = [];
while ($row = $result->fetch_assoc()) {
    $machines[] = $row;
}

header("Content-Type: application/json");
echo json_encode($machines);
?>
