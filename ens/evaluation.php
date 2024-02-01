<!DOCTYPE html>
<html lang="f">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
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
                            <li>creer une evaluation</li>
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



            <form action="" method="post">
                <h2>créer une évaluation</h2>
                <label for="">nom de la matiere</label>
                <input type="text">
                <label for="">votre question </label>
                <input type="text" placeholder="quel etait votre niveau avant...">
                <label for="">1</label>
                <input type="radio" name="" id="" value="1">
                <label for="">2</label>
                <input type="radio" name="" id="" value="1">
                <label for="">3</label>
                <input type="radio" name="" id="" value="1">
                <label for="">4</label>
                <input type="radio" name="" id="" value="1">
                <label for="">5</label>
                <input type="radio" name="" id="" value="1">
                <label for="">6</label>
                <input type="radio" name="" id="" value="1">
                <label for="">7</label>
                <input type="radio" name="" id="" value="1">
                <label for="">8</label>
                <input type="radio" name="" id="" value="1">
                <label for="">9</label>
                <input type="radio" name="" id="" value="1">
                <label for="">10</label>
                <input type="radio" name="" id="" value="1">
            </form>


























        </section>
    </section>
    <script src="./assets/js/main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

</html>