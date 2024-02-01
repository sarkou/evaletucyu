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
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chart.js avec données de la base de données</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
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
</body>

</html>