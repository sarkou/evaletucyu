<?php
// Connexion à la base de données
$host = "postgresql-piscine.alwaysdata.net";
$database = "piscine_evaletu";
$user = "piscine";
$password = "projetbdreseauf@c";

$conn = new PDO("pgsql:host=$host;dbname=$database", $user, $password);

// ID de l'étudiant (vous devez l'obtenir d'une manière ou d'une autre)
$id_etudiant = 1;

// Récupérer les données depuis la base de données
$query = "SELECT matiere, note_avant, note_apres FROM evaluation WHERE id_etudiant = :id_etudiant";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id_etudiant', $id_etudiant, PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Préparer les données pour le script Chart.js
$labels = array_column($data, 'matiere');
$note_avant = array_column($data, 'note_avant');
$note_apres = array_column($data, 'note_apres');

?>






<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>EtudEval</title>
</head>

<body>
    <section class="container_dashboard">

        <section class="menu_dashboard">
            <h1>EtudEval CYU</h1>
            <section>
                <span>
                    <a class="color_blanc" href="./tableaubord.php">
                        <ul class="item_dashboard">
                            <li><ion-icon name="home-outline"></ion-icon></li>
                            <li>Tableau de bord</li>
                        </ul>
                    </a>
                </span>
                <span>
                    <a class="color_blanc" href="./evaluation.php">
                        <ul class="item_dashboard">
                            <li><ion-icon name="apps-outline"></ion-icon></li>
                            <li>Evaluation</li>
                        </ul>
                    </a>
                </span>
                <div>
                    <a class="color_blanc" href="./statistique.php">
                        <ul class="item_dashboard">
                            <li><ion-icon name="stats-chart-outline"></ion-icon></li>
                            <li>Statistique</li>
                        </ul>
                    </a>
                </div>
                <div>
                    <a class="color_blanc" href="./deconnexion.php">
                        <ul class="item_dashboard">
                            <li><ion-icon name="exit-outline"></ion-icon></li>
                            <li>Deconnexion</li>
                        </ul>
                    </a>
                </div>



            </section>
        </section>
        <section class="display_dashboard">
            <h2><ion-icon name="reorder-three-outline"></ion-icon></h2>


            <div>
                <canvas id="myChart"></canvas>
            </div>

            <script>
                const ctx = document.getElementById('myChart');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: <?php echo json_encode($labels); ?>,
                        datasets: [{
                            label: 'niveau avant',
                            data: <?php echo json_encode($note_avant); ?>,
                            borderWidth: 1
                        }, {
                            label: 'niveau apres',
                            data: <?php echo json_encode($note_apres); ?>,
                            borderWidth: 1
                        }]
                    },

                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>





        </section>
    </section>
    <script src="./assets/js/main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

</html>