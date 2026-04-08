<?php
session_start();
include "connexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($connexion, "SELECT utilisateur_id, nom, prenoms, mot_de_passe, role FROM utilisateurs WHERE email = ?");
    if (!$stmt) {
        die("Erreur préparation requête : " . mysqli_error($connexion));
    }
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        $_SESSION['user_id']   = $user['utilisateur_id'];
        $_SESSION['user_nom']  = $user['nom'];
        $_SESSION['user_prenoms'] = $user['prenoms'];
        $_SESSION['user_role'] = $user['role'];

        if ($user['role'] === 'gestionnaire') {
            header('Location: dashboard_gestionnaire.php');
        } elseif ($user['role'] === 'Administrateur') {
            header('Location: dashboard_administrateur.php');
        } else {
            header('Location: connecter.php?error=Rôle+inconnu.');
        }
        exit;
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            width: 350px;
            text-align: center;
        }
        input[type="email"], input[type="password"] {
            width: 90%;
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
        .error   { color: red;   margin-bottom: 10px; }
        .success { color: green; margin-bottom: 10px; }
        a { display: block; margin-top: 20px; text-decoration: none; color: #3498db; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Connexion</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($_GET['success'])): ?>
        <div class="success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Votre Email" required><br>
        <input type="password" name="password" placeholder="Votre Mot de passe" required><br>
        <button type="submit">Se connecter</button>
    </form>

    <a href="inscription.php">Pas encore inscrit ? S'inscrire</a>
</div>
</body>
</html>
