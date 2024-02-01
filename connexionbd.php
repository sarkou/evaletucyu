<?php

// Informations de connexion à la base de données
$serveur = "postgresql-piscine.alwaysdata.net"; // Adresse du serveur PostgreSQL
$utilisateur = "piscine"; // Nom d'utilisateur PostgreSQL
$motDePasse = "projetbdreseauf@c"; // Mot de passe PostgreSQL
$baseDeDonnees = "piscine_evaletu"; // Nom de la base de données

try {
    // Connexion à la base de données
    $connexion = new PDO("pgsql:host=$serveur;dbname=$baseDeDonnees", $utilisateur, $motDePasse);

    // Afficher un message en cas de succès
    echo "Connexion réussie !";

    // Fermer la connexion (à faire à la fin de l'utilisation de la base de données)
    $connexion = null;
} catch (PDOException $e) {
    // En cas d'erreur, afficher le message d'erreur
    die("Échec de la connexion : " . $e->getMessage());
}
