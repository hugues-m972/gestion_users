<?php
session_start();
include 'connexion.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'gestionnaire') {
    header('Location: connecter.php');
    exit();
}

// Statistiques rapides
$nb_produits   = mysqli_fetch_row(mysqli_query($connexion, "SELECT COUNT(*) FROM produits"))[0];
$nb_categories = mysqli_fetch_row(mysqli_query($connexion, "SELECT COUNT(*) FROM categories"))[0];
$nb_ventes     = mysqli_fetch_row(mysqli_query($connexion, "SELECT COUNT(*) FROM ventes"))[0];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Gestionnaire</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .sidebar { width: 220px; min-height: 100vh; background-color: #2c3e50; position: fixed; top: 0; left: 0; padding: 20px; }
        .sidebar h2 { color: #ecf0f1; font-size: 1.1rem; margin-bottom: 30px; }
        .sidebar a { color: #bdc3c7; display: block; margin-bottom: 12px; text-decoration: none; padding: 8px 10px; border-radius: 5px; }
        .sidebar a:hover { background-color: #3498db; color: white; }
        .content { margin-left: 240px; padding: 30px; }
    </style>
</head>
<body class="bg-light">

<div class="sidebar">
    <h2>🏪 Marché Dantokpa</h2>
    <a href="dashboard_gestionnaire.php">🏠 Tableau de bord</a>
    <a href="ajout_categorie.php">➕ Ajouter catégorie</a>
    <a href="liste_categories.php">📂 Liste catégories</a>
    <a href="ajout_produit.php">➕ Ajouter produit</a>
    <a href="index.php">📦 Liste produits</a>
    <a href="ajout_vente.php">💰 Enregistrer vente</a>
    <a href="liste_ventes.php">📊 Liste des ventes</a>
    <a href="logout.php">🔓 Se déconnecter</a>
</div>

<div class="content">
    <h1 class="mb-1">Bienvenue, <?= htmlspecialchars($_SESSION['user_nom']) ?> </h1>
    <p class="text-muted mb-4">Tableau de bord Gestionnaire</p>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Produits</h5>
                    <p class="card-text fs-3 fw-bold"><?= $nb_produits ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Catégories</h5>
                    <p class="card-text fs-3 fw-bold"><?= $nb_categories ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Ventes</h5>
                    <p class="card-text fs-3 fw-bold"><?= $nb_ventes ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <a href="ajout_produit.php" class="btn btn-primary w-100 py-3">➕ Ajouter un produit</a>
        </div>
        <div class="col-md-6">
            <a href="ajout_vente.php" class="btn btn-success w-100 py-3">💰 Enregistrer une vente</a>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
