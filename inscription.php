<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            width: 350px;
            text-align: center;
        }
        input[type="email"], input[type="password"], input[type="text"] {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            margin-top: 10px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button:hover { background-color: #2980b9; }
        .error { color: red; margin-bottom: 10px; }
        .success { color: green; margin-bottom: 10px; }
        a { display: block; margin-top: 20px; text-decoration: none; color: #3498db; }
    </style>
</head>
<body>
<div class="login-box">
    <h1>Inscription</h1>

    <?php if (!empty($_GET['error'])): ?>
        <div class="error"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <form method="POST" action="tr_inscription.php">
        <input type="text" name="nom" placeholder="Votre nom" required><br>
        <input type="text" name="prenoms" placeholder="Votre prénom" required><br>
        <input type="email" name="email" placeholder="Votre Email" required><br>
        <select name="role" required>
            <option value="">Sélectionner le rôle</option>
            <option value="gestionnaire">gestionnaire</option>
            <option value="Administrateur">Administrateur</option>
        </select>
        <input type="password" name="mot_de_passe" placeholder="Votre Mot de passe" required><br>
        <button type="submit">S'inscrire</button>
    </form>

    <a href="connexion.php">Déjà inscrit ? Se connecter</a>
</div>
</body>
</html>
