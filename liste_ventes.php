<?php
session_start();
include 'connexion.php';

if (!isset($_SESSION['user_role'])) {
    header('Location: connecter.php');
    exit();
}

$ventes = mysqli_query($connexion,
    "SELECT v.vente_id, p.nom AS nom_produit, v.date_vente, v.quantite, v.montant_total
     FROM ventes v
     JOIN produits p ON v.produit_id = p.produit_id
     ORDER BY v.vente_id DESC"
);

$ca_total = mysqli_fetch_row(mysqli_query($connexion, "SELECT COALESCE(SUM(montant_total), 0) FROM ventes"))[0];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des ventes</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">📊 Historique des ventes</h1>
        <a href="ajout_vente.php" class="btn btn-success">💰 Nouvelle vente</a>
    </div>

    <div class="alert alert-info fw-bold">
        Chiffre d'affaires total : <?= number_format($ca_total, 0, ',', ' ') ?> FCFA
    </div>

    <?php if ($ventes && mysqli_num_rows($ventes) > 0): ?>
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Produit</th>
                            <th>Date</th>
                            <th>Quantité</th>
                            <th>Montant total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($v = mysqli_fetch_assoc($ventes)): ?>
                        <tr>
                            <td><?= $v['vente_id'] ?></td>
                            <td><strong><?= htmlspecialchars($v['nom_produit']) ?></strong></td>
                            <td><?= htmlspecialchars($v['date_vente']) ?></td>
                            <td><?= $v['quantite'] ?></td>
                            <td><?= number_format($v['montant_total'], 0, ',', ' ') ?> FCFA</td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-info text-center">
        Aucune vente enregistrée. <a href="ajout_vente.php" class="alert-link">Enregistrer une vente</a>.
    </div>
    <?php endif; ?>

</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
