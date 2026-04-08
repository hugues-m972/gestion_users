<?php
session_start();
include 'connexion.php';

if (!isset($_SESSION['user_role'])) {
    header('Location: connecter.php');
    exit();
}

$categories = mysqli_query($connexion, "SELECT * FROM categories ORDER BY categorie_id DESC");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des catégories</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6">📂 Liste des catégories</h1>
        <a href="ajout_categorie.php" class="btn btn-primary">➕ Nouvelle catégorie</a>
    </div>

    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Opération effectuée avec succès !</div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?= $_GET['error'] == 'fk' ? 'Impossible de supprimer : des produits utilisent cette catégorie.' : 'Une erreur est survenue.' ?>
    </div>
    <?php endif; ?>

    <?php if ($categories && mysqli_num_rows($categories) > 0): ?>
    <div class="card shadow">
        <div class="card-body p-0">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                    <tr>
                        <td><?= $cat['categorie_id'] ?></td>
                        <td><strong><?= htmlspecialchars($cat['nom']) ?></strong></td>
                        <td><?= htmlspecialchars($cat['description']) ?></td>
                        <td class="text-center">
                            <a href="modifier_categorie.php?id=<?= $cat['categorie_id'] ?>" class="btn btn-sm btn-outline-primary">✏️ Modifier</a>
                            <a href="supprimer_categorie.php?id=<?= $cat['categorie_id'] ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Supprimer cette catégorie ?');">🗑️ Supprimer</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-info text-center">
        Aucune catégorie trouvée. <a href="ajout_categorie.php" class="alert-link">Ajouter une catégorie</a>.
    </div>
    <?php endif; ?>

</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
