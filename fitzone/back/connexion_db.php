<?php
// back/connexion_db.php
$conn = new mysqli("localhost", "root", "", "fitzone_db");
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}
$conn->set_charset("utf8");
?>
