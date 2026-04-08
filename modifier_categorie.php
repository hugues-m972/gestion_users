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

$stmt = mysqli_prepare($connexion, "SELECT * FROM categories WHERE categorie_id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$cat = mysqli_fetch_assoc($result);

if (!$cat) {
    header('Location: liste_categories.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la catégorie</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width:600px;">
    <h4 class="mb-3 text-primary fw-bold">✏️ Modifier la catégorie</h4>

    <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">Une erreur est survenue. Veuillez réessayer.</div>
    <?php endif; ?>

    <form action="tr_modifier_categorie.php" method="post">
        <input type="hidden" name="categorie_id" value="<?= $cat['categorie_id'] ?>">
        <div class="mb-3">
            <label class="form-label fw-bold">Nom de la catégorie</label>
            <input type="text" class="form-control" name="nom" value="<?= htmlspecialchars($cat['nom']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Description</label>
            <textarea class="form-control" name="description"><?= htmlspecialchars($cat['description']) ?></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Enregistrer</button>
        <a href="liste_categories.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
