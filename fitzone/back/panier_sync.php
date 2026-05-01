<?php
// back/panier_sync.php — saves a commande id into PHP session
session_start();
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$id   = intval($data["id"] ?? 0);

if ($id) {
    if (!isset($_SESSION["panier_ids"])) $_SESSION["panier_ids"] = [];
    if (!in_array($id, $_SESSION["panier_ids"])) {
        $_SESSION["panier_ids"][] = $id;
    }
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}
?>
