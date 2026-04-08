<?php
session_start();
include 'connexion.php';

if (!isset($_SESSION['user_role'])) {
    header('Location: connecter.php');
    exit();
}

$produits = mysqli_query($connexion, "SELECT produit_id, nom, prix_vente, quantite, statut FROM produits WHERE quantite > 0 ORDER BY nom");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer une vente</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width:600px;">
    <h4 class="mb-3 text-primary fw-bold">💰 Enregistrer une vente</h4>

    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Vente enregistrée avec succès !</div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?php
        $err = $_GET['error'];
        if ($err === 'stock') echo "Stock insuffisant pour ce produit.";
        elseif ($err == 2) echo "Veuillez remplir tous les champs.";
        elseif ($err == 3) echo "La quantité doit être un nombre entier supérieur à 0.";
        else echo "Une erreur est survenue.";
        ?>
    </div>
    <?php endif; ?>

    <form action="tr_ajout_vente.php" method="post">
        <div class="mb-3">
            <label class="form-label fw-bold">Produit</label>
            <select name="produit_id" id="produit_id" class="form-control" required onchange="updatePrix()">
                <option value="">Sélectionnez un produit</option>
                <?php while ($p = mysqli_fetch_assoc($produits)): ?>
                    <option value="<?= $p['produit_id'] ?>"
                            data-prix="<?= $p['prix_vente'] ?>"
                            data-stock="<?= $p['quantite'] ?>">
                        <?= htmlspecialchars($p['nom']) ?> — Stock: <?= $p['quantite'] ?> — <?= $p['prix_vente'] ?> FCFA/u
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Quantité vendue</label>
            <input type="number" min="1" class="form-control" name="quantite" id="quantite" placeholder="Ex: 5" required oninput="updateTotal()">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Montant total estimé</label>
            <input type="text" class="form-control" id="montant_affiche" readonly placeholder="Calculé automatiquement">
        </div>
        <button type="submit" name="submit" class="btn btn-success">Enregistrer la vente</button>
        <a href="liste_ventes.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<script>
function updatePrix() {
    updateTotal();
}
function updateTotal() {
    const select = document.getElementById('produit_id');
    const option = select.options[select.selectedIndex];
    const prix   = parseFloat(option.dataset.prix) || 0;
    const qte    = parseInt(document.getElementById('quantite').value) || 0;
    document.getElementById('montant_affiche').value = (prix * qte).toFixed(0) + ' FCFA';
}
</script>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
