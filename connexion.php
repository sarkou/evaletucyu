<?php
session_start(); // Démarre la session

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'e-mail et le mot de passe saisis par l'utilisateur
    $email = $_POST["email"];
    $motDePasseSaisi = $_POST["password"];

    // Vérifier si la clé "mot_de_passe_unique" est définie dans la session
    if (isset($_SESSION['mot_de_passe_unique'])) {
        // Récupérer le mot de passe de la variable de session
        $motDePasseAttendu = $_SESSION['mot_de_passe_unique'];

        if ($motDePasseSaisi == $motDePasseAttendu) {
            // Rediriger vers la page tableau de bord
            header("Location: tableaubord.php");
            exit();
        } else {
            echo "Mot de passe incorrect";
        }
    } else {
        echo "Erreur : La clé 'mot_de_passe_unique' n'est pas définie dans la session.";
    }
}

// Vérifier si l'e-mail est présent dans la session
$emailDansSession = isset($_SESSION['email_utilisateur']) ? $_SESSION['email_utilisateur'] : '';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
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
            <form class="form_connexion" action="" method="post">
                <span class="email_connexion">
                    <label for="email">E-mail:</label>
                    <!-- Afficher l'e-mail dans l'input si présent dans la session -->
                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($emailDansSession) ?>" required>

                    <label for="password">Mot de passe:</label>
                    <input type="password" name="password" id="password" required>
                </span>
                <button type="submit">Se connecter</button>
                <p class="p_generate "><a href="./index.php">Generer un autre mot de passe </a></p>
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
        <span>
            <p>Année : 2023 - 2024 </p>
            <p>CYU Cergy Paris Université</p>
        </span>
    </footer>
    <script src="./assets/js/main.js"></script>
</body>

</html>