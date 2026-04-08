<?php
session_start();
include 'connexion.php';

if (!isset($_SESSION['user_role'])) {
    header('Location: connecter.php');
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit();
}

$stmt = mysqli_prepare($connexion, "SELECT * FROM produits WHERE produit_id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$produit = mysqli_fetch_assoc($result);

if (!$produit) {
    header('Location: index.php');
    exit();
}

$categories = mysqli_query($connexion, "SELECT * FROM categories");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le produit</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width:600px;">
    <h4 class="mb-3 text-primary fw-bold">✏️ Modifier le produit</h4>

    <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?php
        $err = $_GET['error'];
        if ($err == 2) echo "Veuillez remplir tous les champs.";
        elseif ($err == 3) echo "Les prix et la quantité doivent être des nombres valides supérieurs à 0.";
        else echo "Une erreur est survenue.";
        ?>
    </div>
    <?php endif; ?>

    <form action="tr_modifier_produit.php" method="post">
        <input type="hidden" name="produit_id" value="<?= $produit['produit_id'] ?>">
        <div class="mb-3">
            <label class="form-label fw-bold">Nom du produit</label>
            <input type="text" class="form-control" name="nom" value="<?= htmlspecialchars($produit['nom']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Prix d'achat (FCFA)</label>
            <input type="number" step="0.01" min="0.01" class="form-control" name="prix_achat" value="<?= $produit['prix_achat'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Prix de vente (FCFA)</label>
            <input type="number" step="0.01" min="0.01" class="form-control" name="prix_vente" value="<?= $produit['prix_vente'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Quantité</label>
            <input type="number" min="0" class="form-control" name="quantite" value="<?= $produit['quantite'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Catégorie</label>
            <select name="categorie_id" class="form-control" required>
                <option value="">Sélectionnez une catégorie</option>
                <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?= (int)$cat['categorie_id'] ?>"
                        <?= $cat['categorie_id'] == $produit['categorie_id'] ? 'selected' : '' ?>>
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
