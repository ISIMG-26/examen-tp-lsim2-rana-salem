<?php
// back/panier_remove.php — removes an item from the cart
session_start();
require_once "connexion_db.php";
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$id   = intval($data["id"] ?? 0);

if (!$id) {
    echo json_encode(["success" => false]);
    exit();
}

// Remove from DB
$stmt = $conn->prepare("DELETE FROM commandes WHERE id = ? AND statut = 'panier'");
$stmt->bind_param("i", $id);
$stmt->execute();

// Remove from session
if (isset($_SESSION["panier_ids"])) {
    $_SESSION["panier_ids"] = array_values(array_filter($_SESSION["panier_ids"], fn($v) => $v != $id));
}

echo json_encode(["success" => true]);
?>
