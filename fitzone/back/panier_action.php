<?php
// back/panier_action.php
require_once "connexion_db.php";

header("Content-Type: application/json");

$data   = json_decode(file_get_contents("php://input"), true);
$action = $data["action"] ?? "panier";

// ── ADD TO CART (no client info needed) ──────────────────
if ($action === "panier") {
    $machine_id = intval($data["machine_id"] ?? 0);
    if (!$machine_id) {
        echo json_encode(["success" => false, "message" => "Machine invalide."]);
        exit();
    }
    $stmt = $conn->prepare("SELECT nom, prix FROM machines WHERE id = ?");
    $stmt->bind_param("i", $machine_id);
    $stmt->execute();
    $machine = $stmt->get_result()->fetch_assoc();
    if (!$machine) {
        echo json_encode(["success" => false, "message" => "Machine introuvable."]);
        exit();
    }
    // Store as pending (no client info yet — placeholders)
    $ins = $conn->prepare("INSERT INTO commandes (client_nom, client_email, client_phone, machine_id, machine_nom, machine_prix, statut) VALUES ('', '', '', ?, ?, ?, 'panier')");
    $ins->bind_param("isd", $machine_id, $machine["nom"], $machine["prix"]);
    if ($ins->execute()) {
        echo json_encode([
            "success"    => true,
            "message"    => "🛒 " . $machine["nom"] . " ajouté au panier !",
            "commande_id"=> $conn->insert_id
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur base de données."]);
    }
    exit();
}

// ── BUY (client info required) ───────────────────────────
if ($action === "achete") {
    $commande_id  = intval($data["commande_id"] ?? 0);
    $client_nom   = trim($data["nom"]   ?? "");
    $client_email = trim($data["email"] ?? "");
    $client_phone = trim($data["phone"] ?? "");

    if (!$commande_id || !$client_nom || !$client_email || !$client_phone) {
        echo json_encode(["success" => false, "message" => "Tous les champs sont requis."]);
        exit();
    }

    $upd = $conn->prepare("UPDATE commandes SET client_nom=?, client_email=?, client_phone=?, statut='acheté' WHERE id=?");
    $upd->bind_param("sssi", $client_nom, $client_email, $client_phone, $commande_id);
    if ($upd->execute()) {
        echo json_encode(["success" => true, "message" => "✅ Achat confirmé ! Merci " . htmlspecialchars($client_nom) . " 🎉"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de la confirmation."]);
    }
    exit();
}

echo json_encode(["success" => false, "message" => "Action inconnue."]);
?>
