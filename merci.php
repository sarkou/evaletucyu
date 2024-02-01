<?php
session_start(); // Démarre la session

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>


<body class="heighvh100">

    <header class="header_index">
        <nav>
            <h1>CY Cergy Paris Université</h1>
            <ul>
                <li><a href="./index.php">Accueil</a></li>
                <li><a href="#">instruction</a></li>
            </ul>
        </nav>

    </header>




    <section class="container_index">
        <section class="carte_merci ">

            <h2 class="carte_merci_h2">Merci !</h2>
            <img class="img_email" src="./assets/images/email.jpg" alt="image email">

            <p class="p_merci">Nous avons envoyé un code de connexion à l'adresse e-mail<span class="email_bold"> <?php if (isset($_GET["email"])) {
                                                                                                                        echo htmlspecialchars($_GET["email"]);
                                                                                                                    } ?> </span> que vous nous avez fournie.
            </p>


            <p class="p_merci"> Si vous ne le trouvez pas, veuillez vérifier <span class="spam_merci"> votre dossier de spam</span>

            </p>

            <span class="btn_merci"> <a href="./index.php">retour</a></span>
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