<?php
session_start();
include 'connexion.php';

if (!isset($_SESSION['user_role'])) {
    header("location: connecter.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $nom          = trim($_POST['nom']);
    $prix_achat   = $_POST['prix_achat'];
    $prix_vente   = $_POST['prix_vente'];
    $quantite     = $_POST['quantite'];
    $categorie_id = $_POST['categorie_id'];

    // Validation champs vides
    if (empty($nom) || $prix_achat === '' || $prix_vente === '' || $quantite === '' || empty($categorie_id)) {
        header("location: ajout_produit.php?error=2");
        exit();
    }

    // Validation numérique
    if (!is_numeric($prix_achat) || !is_numeric($prix_vente) || !is_numeric($quantite)
        || $prix_achat <= 0 || $prix_vente <= 0 || $quantite < 0) {
        header("location: ajout_produit.php?error=3");
        exit();
    }

    $prix_achat   = (float)$prix_achat;
    $prix_vente   = (float)$prix_vente;
    $quantite     = (int)$quantite;
    $categorie_id = (int)$categorie_id;

    // Calcul automatique du statut
    if ($quantite === 0) {
        $statut = 'rupture';
    } elseif ($quantite <= 10) {
        $statut = 'faible';
    } else {
        $statut = 'en stock';
    }

    $stmt = mysqli_prepare($connexion, "INSERT INTO produits (nom, categorie_id, prix_achat, prix_vente, quantite, statut) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        header("location: ajout_produit.php?error=1");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "siddis", $nom, $categorie_id, $prix_achat, $prix_vente, $quantite, $statut);

    if (mysqli_stmt_execute($stmt)) {
        header("location: ajout_produit.php?success=1");
    } else {
        header("location: ajout_produit.php?error=1");
    }
    exit();
} else {
    header("location: ajout_produit.php");
    exit();
}
?>
