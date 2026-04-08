<?php
$hostname = "localhost";   //Adresse du serveur MySQL
$username = "root";         //Nom d'utilisateur MySQL
$password = "";             //Mot de passe MySQL (vide par défaut dans XAMPP)
$database = "gestion_users";        //Nom de la base de données

//Connexion à la base de données
$connexion = mysqli_connect(hostname: $hostname, username: $username, password: $password, database: $database);

//Vérification de la connexion
if (!$connexion) {
    die("Connexion echouee : " . mysqli_connect_error());
}
?>