<?php
session_start();
include 'connexion.php';

if (!isset($_SESSION['user_role'])) {
    header('Location: connecter.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $id           = (int)$_POST['produit_id'];
    $nom          = trim($_POST['nom']);
    $prix_achat   = $_POST['prix_achat'];
    $prix_vente   = $_POST['prix_vente'];
    $quantite     = $_POST['quantite'];
    $categorie_id = (int)$_POST['categorie_id'];

    if (empty($nom) || $prix_achat === '' || $prix_vente === '' || $quantite === '' || $categorie_id <= 0) {
        header("Location: modifier_produit.php?id=$id&error=2");
        exit();
    }

    if (!is_numeric($prix_achat) || !is_numeric($prix_vente) || !is_numeric($quantite)
        || $prix_achat <= 0 || $prix_vente <= 0 || $quantite < 0) {
        header("Location: modifier_produit.php?id=$id&error=3");
        exit();
    }

    $prix_achat = (float)$prix_achat;
    $prix_vente = (float)$prix_vente;
    $quantite   = (int)$quantite;

    if ($quantite === 0) {
        $statut = 'rupture';
    } elseif ($quantite <= 10) {
        $statut = 'faible';
    } else {
        $statut = 'en stock';
    }

    $stmt = mysqli_prepare($connexion, "UPDATE produits SET nom=?, categorie_id=?, prix_achat=?, prix_vente=?, quantite=?, statut=? WHERE produit_id=?");
    mysqli_stmt_bind_param($stmt, "siddisi", $nom, $categorie_id, $prix_achat, $prix_vente, $quantite, $statut, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?success=1");
    } else {
        header("Location: modifier_produit.php?id=$id&error=1");
    }
    exit();
} else {
    header('Location: index.php');
    exit();
}
?>
