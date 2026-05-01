<?php
// back/login.php
session_start();
require_once "connexion_db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, nom, password FROM utilisateurs WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        header("Location: ../auth.php?error=utilisateur_introuvable");
        exit();
    }

    $stmt->bind_result($id, $nom, $hash);
    $stmt->fetch();

    if (!password_verify($password, $hash)) {
        header("Location: ../auth.php?error=mot_de_passe_incorrect");
        exit();
    }

    $_SESSION["user_id"]  = $id;
    $_SESSION["user_nom"] = $nom;
    header("Location: ../index.php");
    exit();
}
?>
