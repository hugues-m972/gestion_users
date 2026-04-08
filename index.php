<?php
session_start();
include "connexion.php";

if (!isset($_SESSION['user_role'])) {
    header('Location: connecter.php');
    exit();
}

$resultat    = mysqli_query($connexion, "SELECT p.*, c.nom AS nom_categorie FROM produits p JOIN categories c ON p.categorie_id = c.categorie_id");
$res_categories = mysqli_query($connexion, "SELECT * FROM categories");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-5">📋 Liste des produits</h1>
        <a href="ajout_produit.php" class="btn btn-primary">➕ Nouveau produit</a>
    </div>

    <!-- Recherche + filtre catégorie -->
    <div class="row g-2 mb-3">
        <div class="col-md-8">
            <input type="text" id="search" class="form-control" placeholder="🔍 Rechercher par nom...">
        </div>
        <div class="col-md-4">
            <select id="filtreCategorie" class="form-select">
                <option value="">-- Toutes les catégories --</option>
                <?php while ($cat = mysqli_fetch_assoc($res_categories)): ?>
                    <option value="<?= htmlspecialchars($cat['nom']) ?>">
                        <?= htmlspecialchars($cat['nom']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
    </div>

    <p id="compteur" class="fw-bold"></p>
    <p id="noResult" class="text-danger fw-bold"></p>

    <?php if ($resultat && mysqli_num_rows($resultat) > 0): ?>
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Nom</th>
                            <th>Prix d'achat</th>
                            <th>Prix de vente</th>
                            <th>Quantité</th>
                            <th>Statut</th>
                            <th>Catégorie</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                    <?php while ($row = mysqli_fetch_assoc($resultat)): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($row['nom']) ?></strong></td>
                            <td><?= htmlspecialchars($row['prix_achat']) ?> FCFA</td>
                            <td><?= htmlspecialchars($row['prix_vente']) ?> FCFA</td>
                            <td><?= htmlspecialchars($row['quantite']) ?></td>
                            <td>
                                <?php
                                $badge = match($row['statut']) {
                                    'en stock' => 'success',
                                    'faible'   => 'warning',
                                    'rupture'  => 'danger',
                                    default    => 'secondary'
                                };
                                ?>
                                <span class="badge bg-<?= $badge ?>"><?= htmlspecialchars($row['statut']) ?></span>
                            </td>
                            <td><?= htmlspecialchars($row['nom_categorie']) ?></td>
                            <td class="text-center">
                                <a href="modifier_produit.php?id=<?= $row['produit_id'] ?>" class="btn btn-sm btn-outline-primary">✏️</a>
                                <a href="supprimer_produit.php?id=<?= $row['produit_id'] ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Supprimer ce produit ?');">🗑️</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-info text-center">
        Aucun produit trouvé. <a href="ajout_produit.php" class="alert-link">Ajouter un nouveau produit</a>.
    </div>
    <?php endif; ?>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput     = document.getElementById("search");
    const filtreCategorie = document.getElementById("filtreCategorie");
    const lignes          = document.querySelectorAll("#tableBody tr");
    const compteur        = document.getElementById("compteur");
    const noResult        = document.getElementById("noResult");

    function mettreAJourCompteur(nb) {
        compteur.textContent = "Nombre de produits affichés : " + nb;
    }
    mettreAJourCompteur(lignes.length);

    function filtrer() {
        const valeur    = searchInput.value.toLowerCase();
        const categorie = filtreCategorie.value.toLowerCase();
        let count = 0;

        lignes.forEach(function (ligne) {
            const nom      = ligne.children[0].textContent.toLowerCase();
            const cat      = ligne.children[5].textContent.toLowerCase().trim();
            const matchNom = nom.includes(valeur);
            const matchCat = categorie === "" || cat === categorie;

            if (matchNom && matchCat) {
                ligne.style.display = "";
                count++;
            } else {
                ligne.style.display = "none";
            }
        });

        mettreAJourCompteur(count);
        noResult.textContent = count === 0 ? "Aucun produit trouvé 😢" : "";
    }

    searchInput.addEventListener("keyup", filtrer);
    filtreCategorie.addEventListener("change", filtrer);
});
</script>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
