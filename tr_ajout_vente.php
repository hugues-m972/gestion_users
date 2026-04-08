<?php
session_start();
include 'connexion.php';

if (!isset($_SESSION['user_role'])) {
    header('Location: connecter.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $produit_id = (int)$_POST['produit_id'];
    $quantite   = $_POST['quantite'];

    if ($produit_id <= 0 || $quantite === '') {
        header("Location: ajout_vente.php?error=2");
        exit();
    }

    if (!is_numeric($quantite) || (int)$quantite <= 0) {
        header("Location: ajout_vente.php?error=3");
        exit();
    }

    $quantite = (int)$quantite;

    // Récupérer le produit (stock + prix_vente)
    $stmt = mysqli_prepare($connexion, "SELECT quantite, prix_vente FROM produits WHERE produit_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $produit_id);
    mysqli_stmt_execute($stmt);
    $res     = mysqli_stmt_get_result($stmt);
    $produit = mysqli_fetch_assoc($res);

    if (!$produit) {
        header("Location: ajout_vente.php?error=1");
        exit();
    }

    // Vérifier stock suffisant
    if ($quantite > $produit['quantite']) {
        header("Location: ajout_vente.php?error=stock");
        exit();
    }

    $montant_total  = $quantite * $produit['prix_vente'];
    $date_vente     = date('Y-m-d');
    $nouveau_stock  = $produit['quantite'] - $quantite;

    // Calcul nouveau statut
    if ($nouveau_stock === 0) {
        $statut = 'rupture';
    } elseif ($nouveau_stock <= 10) {
        $statut = 'faible';
    } else {
        $statut = 'en stock';
    }

    // Insérer la vente
    $ins = mysqli_prepare($connexion, "INSERT INTO ventes (produit_id, date_vente, quantite, montant_total) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($ins, "isid", $produit_id, $date_vente, $quantite, $montant_total);

    if (!mysqli_stmt_execute($ins)) {
        header("Location: ajout_vente.php?error=1");
        exit();
    }

    // Mettre à jour le stock et le statut du produit
    $upd = mysqli_prepare($connexion, "UPDATE produits SET quantite = ?, statut = ? WHERE produit_id = ?");
    mysqli_stmt_bind_param($upd, "isi", $nouveau_stock, $statut, $produit_id);
    mysqli_stmt_execute($upd);

    header("Location: ajout_vente.php?success=1");
    exit();
} else {
    header('Location: ajout_vente.php');
    exit();
}
?>
