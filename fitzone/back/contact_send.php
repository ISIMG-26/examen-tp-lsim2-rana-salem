<?php
// back/contact_send.php
require_once "connexion_db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom     = trim($_POST["nom"]);
    $email   = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    $stmt = $conn->prepare("INSERT INTO messages (nom, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nom, $email, $message);

    if ($stmt->execute()) {
        header("Location: ../contact.php?success=message_envoye");
    } else {
        header("Location: ../contact.php?error=1");
    }
    exit();
}
?>
