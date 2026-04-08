<?php
session_start();
include 'connexion.php';

if (!isset($_SESSION['user_role'])) {
    header("location: connecter.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $nom         = trim($_POST['nom']);
    $description = trim($_POST['description']);

    if (empty($nom)) {
        header("location: ajout_categorie.php?error=2");
        exit();
    }

    $stmt = mysqli_prepare($connexion, "INSERT INTO categories (nom, description) VALUES (?, ?)");
    if (!$stmt) {
        header("location: ajout_categorie.php?error=1");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $nom, $description);

    if (mysqli_stmt_execute($stmt)) {
        header("location: ajout_categorie.php?success=1");
    } else {
        header("location: ajout_categorie.php?error=1");
    }
    exit();
} else {
    header("location: ajout_categorie.php");
    exit();
}
?>
