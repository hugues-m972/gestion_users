<?php
session_start();
include 'connexion.php';

if (!isset($_SESSION['user_role']) || strtolower($_SESSION['user_role']) !== 'administrateur') {
    header('Location: connecter.php');
    exit();
}

$nb_produits   = mysqli_fetch_row(mysqli_query($connexion, "SELECT COUNT(*) FROM produits"))[0];
$nb_categories = mysqli_fetch_row(mysqli_query($connexion, "SELECT COUNT(*) FROM categories"))[0];
$nb_ventes     = mysqli_fetch_row(mysqli_query($connexion, "SELECT COUNT(*) FROM ventes"))[0];
$ca_total      = mysqli_fetch_row(mysqli_query($connexion, "SELECT COALESCE(SUM(montant_total), 0) FROM ventes"))[0];

$alertes = mysqli_query($connexion, "SELECT nom, quantite, statut FROM produits WHERE statut IN ('faible', 'rupture') ORDER BY statut DESC");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .sidebar { width: 220px; min-height: 100vh; background-color: #1a252f; position: fixed; top: 0; left: 0; padding: 20px; }
        .sidebar h2 { color: #ecf0f1; font-size: 1.1rem; margin-bottom: 30px; }
        .sidebar a { color: #bdc3c7; display: block; margin-bottom: 12px; text-decoration: none; padding: 8px 10px; border-radius: 5px; }
        .sidebar a:hover { background-color: #e74c3c; color: white; }
        .content { margin-left: 240px; padding: 30px; }
    </style>
</head>
<body class="bg-light">

<div class="sidebar">
    <h2>🏪 Marché Dantokpa</h2>
    <a href="dashboard_administrateur.php">🏠 Tableau de bord</a>
    <a href="ajout_categorie.php">➕ Ajouter catégorie</a>
    <a href="liste_categories.php">📂 Liste catégories</a>
    <a href="ajout_produit.php">➕ Ajouter produit</a>
    <a href="index.php">📦 Liste produits</a>
    <a href="ajout_vente.php">💰 Enregistrer vente</a>
    <a href="liste_ventes.php">📊 Liste des ventes</a>
    <a href="logout.php">🔓 Se déconnecter</a>
</div>

<div class="content">
    <h1 class="mb-1">Bienvenue, <?= htmlspecialchars($_SESSION['user_nom']) ?> 👋</h1>
    <p class="text-muted mb-4">Tableau de bord Administrateur</p>

    <!-- Statistiques -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body text-center">
                    <h6>Produits</h6>
                    <p class="fs-2 fw-bold mb-0"><?= $nb_produits ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body text-center">
                    <h6>Catégories</h6>
                    <p class="fs-2 fw-bold mb-0"><?= $nb_categories ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body text-center">
                    <h6>Ventes</h6>
                    <p class="fs-2 fw-bold mb-0"><?= $nb_ventes ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body text-center">
                    <h6>Chiffre d'affaires</h6>
                    <p class="fs-5 fw-bold mb-0"><?= number_format($ca_total, 0, ',', ' ') ?> FCFA</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertes stock -->
    <div class="card mb-4">
        <div class="card-header bg-danger text-white fw-bold">⚠️ Alertes Stock (faible / rupture)</div>
        <div class="card-body p-0">
            <?php if (mysqli_num_rows($alertes) > 0): ?>
            <table class="table table-sm mb-0">
                <thead class="table-light">
                    <tr><th>Produit</th><th>Quantité</th><th>Statut</th></tr>
                </thead>
                <tbody>
                <?php while ($a = mysqli_fetch_assoc($alertes)): ?>
                    <tr>
                        <td><?= htmlspecialchars($a['nom']) ?></td>
                        <td><?= $a['quantite'] ?></td>
                        <td>
                            <span class="badge bg-<?= $a['statut'] === 'rupture' ? 'danger' : 'warning' ?>">
                                <?= htmlspecialchars($a['statut']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p class="p-3 mb-0 text-success">✅ Tous les produits sont en stock suffisant.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <a href="ajout_produit.php" class="btn btn-primary w-100 py-2">➕ Ajouter un produit</a>
        </div>
        <div class="col-md-4">
            <a href="ajout_vente.php" class="btn btn-success w-100 py-2">💰 Enregistrer une vente</a>
        </div>
        <div class="col-md-4">
            <a href="liste_ventes.php" class="btn btn-secondary w-100 py-2">📊 Voir les ventes</a>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
