<?php
session_start();
include 'connexion.php';

if (!isset($_SESSION['user_role'])) {
    header('Location: connecter.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $id          = (int)$_POST['categorie_id'];
    $nom         = trim($_POST['nom']);
    $description = trim($_POST['description']);

    if (empty($nom) || $id <= 0) {
        header("Location: modifier_categorie.php?id=$id&error=1");
        exit();
    }

    $stmt = mysqli_prepare($connexion, "UPDATE categories SET nom = ?, description = ? WHERE categorie_id = ?");
    mysqli_stmt_bind_param($stmt, "ssi", $nom, $description, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: liste_categories.php?success=1");
    } else {
        header("Location: modifier_categorie.php?id=$id&error=1");
    }
    exit();
} else {
    header('Location: liste_categories.php');
    exit();
}
?>
