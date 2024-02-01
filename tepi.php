<?php
session_start(); // Démarre la session

require 'vendor/autoload.php';

use \Mailjet\Resources;

// Informations de connexion à la base de données
$serveur = "postgresql-piscine.alwaysdata.net"; // Adresse du serveur PostgreSQL
$utilisateur = "piscine"; // Nom d'utilisateur PostgreSQL
$motDePasse = "projetbdreseauf@c"; // Mot de passe PostgreSQL
$baseDeDonnees = "piscine_evaletu"; // Nom de la base de données
$erreur_index = "";

// Fonction pour générer un mot de passe aléatoire
function genererMotDePasse()
{
    $longueur = 8;
    $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    return substr(str_shuffle($caracteres), 0, $longueur);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'e-mail de l'utilisateur
    $email = $_POST["email"];

    // Générer un mot de passe unique
    $motDePasseUnique = genererMotDePasse();

    // Stocker le mot de passe dans la variable de session
    $_SESSION['mot_de_passe_unique'] = $motDePasseUnique;

    // Lien vers la page connexion.php
    $lienConnexion = './connexion.php';
    $siteUrl = 'https://' . $_SERVER['HTTP_HOST'];

    // Lien de désabonnement
    $lienDesabonnement = './desabonnement.php'; // Remplacez par le lien réel

    // Paramètres Mailjet
    $mj = new \Mailjet\Client('472beae9c0d2aab8d2548baa91871b5d', '2625cb5dc4b6da1c1b01ab66bd5c0cdb', true, ['version' => 'v3.1']);

    // Contenu de l'e-mail avec le lien de désabonnement
    $message = [
        'From' => [
            'Email' => 'contact@isdira.com',
            'Name' => 'evaletu'
        ],
        'To' => [
            [
                'Email' => $email,
                'Name' => 'Marie Durand'
            ]
        ],
        'Subject' => 'Envoie de votre mot de passe',
        'HTMLPart' => '
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Confirmation de mot de passe</title>
            </head>
            <body>
                <p>Merci de vous être inscrit sur notre site.</p>
                <p>Votre nouveau mot de passe est : <strong>' . $motDePasseUnique . '</strong></p>
                <p>Utilisez ce mot de passe pour vous connecter à votre compte.</p>
                <p>Si vous n\'avez pas demandé de réinitialisation de mot de passe, veuillez ignorer cet e-mail.</p>
                
                <p>Connectez-vous <a href="https://sarkou.alwaysdata.net/evaletucyu/connexion.php">ici</a>.</p>
                <p>Pour vous désabonner, cliquez <a href="https://sarkou.alwaysdata.net/evaletucyu/desabonnement.php">ici</a>.</p>
                
            </body>
            </html>
        ',
        'TextPart' => 'Votre  mot de passe est : ' . $motDePasseUnique . ' Connectez-vous ici : ' . $_SERVER['HTTP_HOST'] . $lienConnexion . ' Pour vous désabonner, visitez ' . $_SERVER['HTTP_HOST'] . $lienDesabonnement . '.',
        'Headers' => [
            'Reply-To' => 'contact@isdira.com',
            'MIME-Version' => '1.0',
            'Content-type' => 'text/html; charset=UTF-8',
        ],
    ];

    // Envoi de l'e-mail via Mailjet
    $response = $mj->post(Resources::$Email, ['body' => ['Messages' => [$message]]]);

    // Vérifier le résultat de l'envoi
    if ($response->success()) {
        // Connexion à la base de données
        try {
            $connexion = new PDO("pgsql:host=$serveur;dbname=$baseDeDonnees", $utilisateur, $motDePasse);

            // Préparer et exécuter la requête d'insertion dans la table personne
            $queryPersonne = "INSERT INTO personne (email, mot_de_passe) VALUES (:email, :motDePasse)";
            $stmtPersonne = $connexion->prepare($queryPersonne);
            $stmtPersonne->bindParam(':email', $email);
            $stmtPersonne->bindParam(':motDePasse', $motDePasseUnique);
            $stmtPersonne->execute();

            // Récupérer l'id_personne généré
            $idPersonne = $connexion->lastInsertId();

            // Préparer et exécuter la requête d'insertion dans la table etudiant
            $queryEtudiant = "INSERT INTO etudiant (id_personne, niveau, filiere) VALUES (:idPersonne, 'L3', 'L3')";
            $stmtEtudiant = $connexion->prepare($queryEtudiant);
            $stmtEtudiant->bindParam(':idPersonne', $idPersonne);
            $stmtEtudiant->execute();

            // Fermer la connexion
            $connexion = null;

            // Redirection vers la page de remerciement
            header("Location: merci.php");
        } catch (PDOException $e) {
            // En cas d'erreur, afficher le message d'erreur
            die("Échec de l'insertion dans la base de données : " . $e->getMessage());
        }
    } else {
        echo 'Échec de l\'envoi de l\'e-mail. Code HTTP : ' . $response->getStatus();
        print_r($response->getBody());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EvalEtud | CYU</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>

<body class="heighvh100">

    <header class="header_index">
        <nav>
            <h1>CYU Cergy Paris Université</h1>
            <ul>
                <li><a href="./index.php">Accueil</a></li>
                <li><a href="#">instruction</a></li>
            </ul>
        </nav>

    </header>




    <section class="container_index">
        <section class="carte_index">
            <form class="form_index" action="./tepi.php" method="post">

                <label for="email">Votre e-mail de l'université</label>
                <input class="email_index" type="email" name="email" id="email" placeholder="prenom.nom@etu.cyu.fr " />


                <button class="btn_index" type="submit">recevoir votre code</button>

                <?php
                if ($erreur_index) {
                    echo "<p>" . $erreur_index . "</p>";
                } ?>
            </form>
        </section>
    </section>

    <footer class="footer_index">

        <span class="auteur">
            <p>Les auteures :</p>
            <ul>
                <li> Shalini KIRITHARAN</li>
                <li> Saran Kaba KOUYATÉ</li>
            </ul>
        </span>
        <span class="fac">


            <p>Année : 2023 - 2024 </p>
            <p>CYU Cergy Paris Université</p>
        </span>



    </footer>
    <script src="./assets/js/main.js"></script>
</body>

</html>