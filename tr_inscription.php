<?php
include "connexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom    = trim($_POST['nom']);
    $prenom = trim($_POST['prenoms']);
    $email  = trim($_POST['email']);
    $role   = $_POST['role'];
    $password = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = mysqli_prepare($connexion, "SELECT utilisateur_id FROM utilisateurs WHERE email = ?");
    if (!$check) {
        die("Erreur préparation requête : " . mysqli_error($connexion));
    }
    mysqli_stmt_bind_param($check, "s", $email);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {
        header("Location: inscription.php?error=Cet+email+est+déjà+utilisé.");
        exit;
    }
    mysqli_stmt_close($check);

    // Insert user
    $stmt = mysqli_prepare($connexion, "INSERT INTO utilisateurs (nom, prenoms, email, mot_de_passe, role) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Erreur préparation insertion : " . mysqli_error($connexion));
    }
    mysqli_stmt_bind_param($stmt, "sssss", $nom, $prenom, $email, $password, $role);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: connecter.php?success=Inscription+réussie+!+Connectez-vous.");
        exit;
    } else {
        header("Location: inscription.php?error=Erreur+lors+de+l'inscription.");
        exit;
    }
} else {
    header("Location: inscription.php");
    exit;
}
?>
