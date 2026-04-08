<?php
session_start();
include 'connexion.php';

if (!isset($_SESSION['user_role'])) {
    header('Location: connecter.php');
    exit();
}

$categories = mysqli_query($connexion, "SELECT * FROM categories");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h4 class="mb-3 text-primary fw-bold">Ajouter un nouveau produit</h4>

    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        Produit ajouté avec succès !
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?php
        $err = $_GET['error'];
        if ($err == 2) echo "Veuillez remplir tous les champs obligatoires.";
        elseif ($err == 3) echo "Les prix et la quantité doivent être des nombres valides supérieurs à 0.";
        else echo "Une erreur est survenue. Veuillez réessayer.";
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <form action="tr_ajout_produit.php" method="post">
        <div class="mb-3">
            <label class="form-label fw-bold">Nom du produit</label>
            <input type="text" class="form-control" name="nom" placeholder="Ex: Riz local" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Prix d'achat (FCFA)</label>
            <input type="number" step="0.01" min="0.01" class="form-control" name="prix_achat" placeholder="Ex: 500" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Prix de vente (FCFA)</label>
            <input type="number" step="0.01" min="0.01" class="form-control" name="prix_vente" placeholder="Ex: 700" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Quantité</label>
            <input type="number" min="0" class="form-control" name="quantite" placeholder="Ex: 50" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Catégorie</label>
            <select name="categorie_id" class="form-control" required>
                <option value="">Sélectionnez une catégorie</option>
                <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?= (int)$cat['categorie_id'] ?>">
                        <?= htmlspecialchars($cat['nom']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Enregistrer</button>
        <a href="index.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
