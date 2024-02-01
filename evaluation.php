<?php
// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Informations de connexion à la base de données
    $serveur = "postgresql-piscine.alwaysdata.net"; // Adresse du serveur PostgreSQL
    $utilisateur = "piscine"; // Nom d'utilisateur PostgreSQL
    $motDePasse = "projetbdreseauf@c"; // Mot de passe PostgreSQL
    $baseDeDonnees = "piscine_evaletu"; // Nom de la base de données

    try {
        // Connexion à la base de données
        $pdo = new PDO("pgsql:host=$serveur;dbname=$baseDeDonnees", $utilisateur, $motDePasse);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connexion réussie !";

        // Récupère les valeurs des inputs radio et du select
        $algorithmique = isset($_POST['algorithmique']) ? $_POST['algorithmique'] : null;
        $reseaux = isset($_POST['reseaux']) ? $_POST['reseaux'] : null;
        $probabilite = isset($_POST['probabilite']) ? $_POST['probabilite'] : null;
        $bd = isset($_POST['bd']) ? $_POST['bd'] : null;
        $bdreseaux = isset($_POST['bdreseaux']) ? $_POST['bdreseaux'] : null;
        $anglais = isset($_POST['anglais']) ? $_POST['anglais'] : null;
        $cati = isset($_POST['cati']) ? $_POST['cati'] : null;
        $ue_libre = isset($_POST['ue_libre']) ? $_POST['ue_libre'] : null;
        $mineure = isset($_POST['mineure']) ? $_POST['mineure'] : null;
        $commentaire = isset($_POST['commentaire']) ? $_POST['commentaire'] : null;

        // Assumez que vous avez déjà une connexion à la base de données
        // Remplacez les valeurs suivantes par les colonnes appropriées de votre table "evaluation"
        $id_etudiant = 1; // Assurez-vous d'avoir l'ID de l'étudiant correct

        // Liste des matières et de leurs identifiants
        $matieres = [
            'UE Algorithmique' => 'algorithmique',
            'UE Réseaux' => 'reseaux',
            'UE Probabilité Statistique' => 'probabilite',
            'UE Base de données' => 'bd',
            'UE projet BD / Réseau' => 'bdreseaux',
            'UE Anglais' => 'anglais',
            'UE CATI' => 'cati',
            // Ajoutez d'autres matières ici
        ];

        // Boucle à travers chaque matière
        foreach ($matieres as $matiereNom => $matiereColonne) {
            // Récupère la note correspondante
            $note = isset($_POST[$matiereColonne]) ? $_POST[$matiereColonne] : null;

            // Insère dans la table "evaluation"
            $query = "INSERT INTO evaluation (id_etudiant, matiere, note_avant, commentaire) 
                      VALUES (:id_etudiant, :matiere, :note, :commentaire)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_etudiant', $id_etudiant, PDO::PARAM_INT);
            $stmt->bindParam(':matiere', $matiereNom, PDO::PARAM_STR);
            $stmt->bindParam(':note', $note, PDO::PARAM_INT);
            $stmt->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
            $stmt->execute();
        }

        // Insérer la valeur pour l'UE Libre
        $ueLibre = isset($_POST['ue_libre']) ? $_POST['ue_libre'] : null;
        $query = "INSERT INTO evaluation (id_etudiant, matiere, note_avant, commentaire) 
                  VALUES (:id_etudiant, :matiere, :note, :commentaire)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_etudiant', $id_etudiant, PDO::PARAM_INT);
        $stmt->bindParam(':matiere', $ueLibre, PDO::PARAM_STR);
        $stmt->bindParam(':note', $note, PDO::PARAM_INT);
        $stmt->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
        $stmt->execute();

        // Insérer la valeur pour la Mineure
        $mineureValue = isset($_POST['mineure']) ? $_POST['mineure'] : null;
        $mineureQuery = "INSERT INTO evaluation (id_etudiant, matiere, note_avant, commentaire) 
                  VALUES (:id_etudiant, :matiere, :note, :commentaire)";
        $mineureStmt = $pdo->prepare($mineureQuery);
        $mineureStmt->bindParam(':id_etudiant', $id_etudiant, PDO::PARAM_INT);
        $mineureStmt->bindParam(':matiere', $mineureValue, PDO::PARAM_STR);
        $mineureStmt->bindParam(':note', $note, PDO::PARAM_INT);
        $mineureStmt->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
        $mineureStmt->execute();
    } catch (PDOException $e) {
        // En cas d'erreur, afficher le message d'erreur
        die("Échec de la connexion : " . $e->getMessage());
    }
}
?>





<!DOCTYPE html>
<html lang="f">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/styles.css">
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



            <form class="form_eval" action="./evaluation.php" method="post">
                <table>
                    <thead>
                        <tr>
                            <th></th> <!-- Cellule vide pour l'alignement -->
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <th><?php echo $i; ?></th> <!-- Labels de 1 à 10 -->
                            <?php endfor; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <h3>UE Algorithmique</h3>
                            </td>
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <td><label for="algorithmique_<?php echo $i; ?>"><?php echo $i; ?></label></td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <td></td> <!-- Cellule vide pour l'alignement -->
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <td><input type="radio" name="algorithmique" id="algorithmique_<?php echo $i; ?>" value="<?php echo $i; ?>" /></td>
                            <?php endfor; ?>
                        </tr>



                        <tr>
                            <td>
                                <h3>UE Réseaux</h3>
                            </td>
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <td><label for="reseaux_<?php echo $i; ?>"><?php echo $i; ?></label></td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <td></td> <!-- Cellule vide pour l'alignement -->
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <td><input type="radio" name="reseaux" id="reseau_<?php echo $i; ?>" value="<?php echo $i; ?>" /></td>
                            <?php endfor; ?>
                        </tr>


                        <tr>
                            <td>
                                <h3>UE Probabilité Statistique</h3>
                            </td>
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <td><label for="proba_<?php echo $i; ?>"><?php echo $i; ?></label></td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <td></td> <!-- Cellule vide pour l'alignement -->
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <td><input type="radio" name="probabilite" id="proba_<?php echo $i; ?>" value="<?php echo $i; ?>" /></td>
                            <?php endfor; ?>
                        </tr>

                        <tr>
                            <td>
                                <h3>UE Base de données</h3>
                            </td>
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <td><label for="bd_<?php echo $i; ?>"><?php echo $i; ?></label></td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <td></td> <!-- Cellule vide pour l'alignement -->
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <td><input type="radio" name="bd" id="bd_<?php echo $i; ?>" value="<?php echo $i; ?>" /></td>
                            <?php endfor; ?>
                        </tr>

                        <tr>
                            <td>
                                <h3>UE projet BD / Reseau</h3>
                            </td>
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <td><label for="bdreseaux_<?php echo $i; ?>"><?php echo $i; ?></label></td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <td></td> <!-- Cellule vide pour l'alignement -->
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <td><input type="radio" name="bdreseaux" id="bdreseau_<?php echo $i; ?>" value="<?php echo $i; ?>" /></td>
                            <?php endfor; ?>
                        </tr>

                        <tr>
                            <td>
                                <h3>UE Anglais</h3>
                            </td>
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <td><label for="anglais_<?php echo $i; ?>"><?php echo $i; ?></label></td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <td></td> <!-- Cellule vide pour l'alignement -->
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <td><input type="radio" name="anglais" id="anglais_<?php echo $i; ?>" value="<?php echo $i; ?>" /></td>
                            <?php endfor; ?>
                        </tr>

                        <tr>
                            <td>
                                <h3>UE CATI</h3>
                            </td>
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <td><label for="cati_<?php echo $i; ?>"><?php echo $i; ?></label></td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <td></td> <!-- Cellule vide pour l'alignement -->
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <td><input type="radio" name="cati" id="cati_<?php echo $i; ?>" value="<?php echo $i; ?>" /></td>
                            <?php endfor; ?>
                        </tr>


                    </tbody>
                </table>







                <h3>Choisissez votre UE Libre</h3>
                <select id="select" onchange="afficherRadio()" name="ue_libre">
                    <?php
                    $options = [
                        'culture_generale' => 'Culture générale et grands débats contemporains',
                        'sociologie' => 'Sociologie des institutions policières',
                        'conception_fabrication' => 'Conception/fabrication en fablab',
                        'introduction_sciences_sociales' => 'Introduction aux sciences sociales',
                        'vote_choix_social' => 'Vote et choix social',
                        'histoire_contemporaine' => 'Histoire contemporaine',
                        'initiation_histoire_publique' => 'Initiation à l’Histoire Publique',
                        'conferences_sujets_scientifiques' => 'Conférences : sujets scientifiques',
                        'animation_ateliers_conversation' => 'Animation d\'ateliers de conversation',
                        'atelier_theatre_plurilingue' => 'Atelier théâtre plurilingue',



                        'ue_libre_arabe_pour_debutants' => 'UE libre arabe pour debutants',
                        'ue_libre_arabe_pour_faux_débutants' => 'UE libre arabe pour faux débutants (P)',
                        'ue_libre_italien' => 'UE libre italien',
                        'ue_libre_lv2_allemand' => 'UE libre LV2 allemand',
                        'arts_plastiques' => 'Arts plastiques',
                        'athletisme' => 'Athletisme',
                        'projets_conference_atelier' => 'Projets, conférences et ateliers autour de la transition écologique et sociétale',
                        'autodéfense' => 'Autodéfense et confiance en soi',
                        'ue_libre_lv2_espagnol' => 'UE libre LV2 espagnol',
                        'basket-ball' => 'Basket-ball',
                        'badminton' => 'Badminton',
                        'ue_libre_portugais' => 'UE libre portugais',
                        'uel_anglais_a12' => 'UEL Anglais (A1-A2)',






                        'uel_anglais_b12' => 'UEL Anglais (B1-B2)',
                        'Ecriture partagée' => 'Ecriture partagée, l\'art en vie',
                        'Escalade' => 'Escalade ',
                        'Esprit_entreprendre' => 'Esprit d\'entreprendre : découvre ton potentiel',


                        "Les_fake_news" => 'Les fake news : aiguisez votre esprit critique !',


                        "football_féminin" => 'Football féminin',



                        "football" => 'Football',



                        "futsal" => 'Futsal',



                        "grappling" => 'Grappling',



                        "handball" => 'Handball',

                        'uel_Anglais_c12' => 'UEL Anglais (C1-C2)',
                        'uel_chinois' => 'UEL Chinois (P)',

                        'Judo_Jujitsu_combat' => 'Judo-Jujitsu combat',



                        "mma" => 'MMA',



                        "musiques_actuelles" => 'Musiques actuelles, de la découverte au partage',
                        "musculation" => 'Musculation',

                        "natation" => 'Natation',
                        "parkour" => 'Parkour',
                        "UEL_Japonais" => 'UEL Japonais',
                        'Rugby' => 'Rugby',
                        'UEL Russe ' => 'UEL Russe (P)',

                        'ue_sante' => 'UE Santé',
                        "PSSM" => 'Premier secours en santé mentale, PSSM',
                        'tennis_de_table' => 'Tennis de table',
                        "Theatre" => 'Théâtre',


                        "Tennis" => 'Tennis',
                        "ultimate" => 'Ultimate',
                        'Volley-ball' => 'Volley-ball',
                        "vttnatation" => 'VTT/Natation',
                        "vtt" => 'VTT',
                        'Production_de_documents' => 'Production de documents (numérique pour tous)',

                        'Savoir_communiquer' => 'Savoir communiquer à l’écrit et à l’oral',
                        'vivre_egalite' => ' VIVRE L’EGALITE. Lutter contre les comportements sexistes'








                    ];

                    foreach ($options as $value => $label) {
                        echo "<option value=\"$value\">$label</option>";
                    }
                    ?>
                </select>






                <?php for ($i = 1; $i <= 10; $i++) : ?>
                    <label class="radio_hidden_libre" for="libre_<?php echo $i; ?>"><?php echo $i ?></label>
                    <input class="radio_hidden_libre" type="radio" name="ue_libre" style="visibility: hidden;" id="libre_<?php echo $i; ?>" value="<?php echo $i; ?> " />
                <?php endfor; ?>








                <!--pour la partie du choix de la mineure-->

                <h3>choisissez votre mineure</h3>
                <select id="select" onchange="afficherRadioM()">

                    <option value="xml">XML</option>
                    <option value="python">Python</option>
                    <option value="informatique_graphique">Infomatique graphique</option>
                    <option value="developpement_web_avance">Dévéloppement web avancé</option>
                </select>




                <?php for ($i = 1; $i <= 10; $i++) : ?>
                    <label class="radio_hidden_mineure" for="mineure_<?php echo $i; ?>"><?php echo $i ?></label>
                    <input class="radio_hidden_mineure" type="radio" name="mineure" style="visibility: hidden;" id="mineure_<?php echo $i; ?>" value="<?php echo $i; ?> " />
                <?php endfor; ?>


                <!--pour la partie du commentaire-->
                <label for="comment">Anonyme à écrit</label>

                <textarea id="comment" name="commentaire" rows="4" cols="50">

                </textarea>
                <button type="submit">Envoyer</button>
            </form>






        </section>
    </section>
    <script src="./assets/js/main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

</html>