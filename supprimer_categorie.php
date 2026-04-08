<?php
session_start();
include 'connexion.php';

if (!isset($_SESSION['user_role'])) {
    header('Location: connecter.php');
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: liste_categories.php');
    exit();
}

// Vérifier si des produits référencent cette catégorie
$check = mysqli_prepare($connexion, "SELECT COUNT(*) FROM produits WHERE categorie_id = ?");
mysqli_stmt_bind_param($check, "i", $id);
mysqli_stmt_execute($check);
$res = mysqli_stmt_get_result($check);
$count = mysqli_fetch_row($res)[0];

if ($count > 0) {
    header("Location: liste_categories.php?error=fk");
    exit();
}

$stmt = mysqli_prepare($connexion, "DELETE FROM categories WHERE categorie_id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: liste_categories.php?success=1");
} else {
    header("Location: liste_categories.php?error=1");
}
exit();
?>
