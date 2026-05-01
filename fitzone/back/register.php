<?php
// back/register.php
session_start();
require_once "connexion_db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom      = trim($_POST["nom"]);
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];

    // Check email exists
    $check = $conn->prepare("SELECT id FROM utilisateurs WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        header("Location: ../auth.php?error=email_existe");
        exit();
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nom, $email, $hash);
    $stmt->execute();

    header("Location: ../auth.php?success=inscription_reussie");
    exit();
}
?>
