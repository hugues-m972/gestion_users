<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Ajouter une categorie</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    

    <div class="container mt-5 pt-5">
    <h4 class="pt-3 mb-3 text-primary fw-bold">Ajouter une nouvelle categorie</h4>

    <!-- Alerte de succès -->
    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
    Categorie ajoutée avec succès !
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Alerte d'erreur -->
    <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show">
    Une erreur est survenue. Veuillez reessayer.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Formulaire d'ajout -->
    <form action="tr_ajout_categorie.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
    <label class="form-label fw-bold">Nom de la categorie</label>
    <input type="text" class="form-control" name="nom" placeholder="Ex: Electroménager" required>
    </div>
    <div class="mb-3">
    <label class="form-label fw-bold">Description</label>
    <textarea class="form-control" name="description" placeholder="Ex: Produits électriques et électroniques" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Enregister</button>
    <button type="button" class="btn btn-secondary" onclick="window.location.href='ajout_categorie.php'">Annulé</button>
    </form>
    </div>
</body>