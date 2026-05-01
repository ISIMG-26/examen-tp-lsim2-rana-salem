<?php
// back/check_email.php - AJAX email availability check
require_once "connexion_db.php";

$email = isset($_GET["email"]) ? trim($_GET["email"]) : "";

$stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

header("Content-Type: application/json");
echo json_encode(["exists" => $stmt->num_rows > 0]);
?>
