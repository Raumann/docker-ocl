<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Favicon -->
        <link rel="shortcut icon" href="#" />

        <!-- Ajout des feuilles de style -->
        <!-- <link rel="stylesheet" href="css/reset.css"> -->
        <link rel="stylesheet" href="assets/css/app.css">

        <title>Memory</title>
    </head>

    <body>
        <div class="wrapper">
            <header class="header">
                <div class="header__content">
                    <h1 class="title">Jeu du memory</h1>

                    <button id="play-game" class="btn btn-primary" type="submit">Jouer</button>

                    <div class="player dnone">
                        <p class="player__count-founded-pair">0 paire trouvée</p>
                    </div>

                    <div class="action-game dnone">
                        <button id="restart-game" class="btn btn-primary" type="submit">Recommencer</button>
                        <button id="exit-game" class="btn btn-danger" type="submit">Quitter</button>
                    </div>
                </div>
            </header>
            
            <main class="main">
                <!-- div contenant le tableau d'affichage des 10 meilleurs scores -->
                <div class="best-score-list">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pseudo</th>
                                <th>Temps (s)</th>
                                <th>Paires trouvées</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $conn = new mysqli("mysql", "root", "dockertest", "memory");
                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                $sql = 'SELECT * FROM score ORDER BY count_founded_pair DESC, duration, count_error LIMIT 10;';
                                $result = $conn->query($sql);

                                // Si la connexion à la bdd se fait bien (bdd memory, table score)
                                if ($result) {
                                    $index = 1;
                                    
                                    // Si il y a des scores d'enregistrés en bdd
                                    while($scores = $result->fetch_assoc())
                                    {
                                        ?>
                                            <tr>
                                                <td><?= $index; ?></td>
                                                <!-- Récupération du nom du joueur grâce à la méthode définie dans ScoreModel -->
                                                <td><?= $scores['name']; ?></td>
                                                <!-- Récupération du temps mis par le joueur grâce à la méthode définie dans ScoreModel -->
                                                <td><?= $scores['duration']; ?></td>
                                                <!-- Récupération du nombre de paire trouvée par le joueur grâce à la méthode définie dans ScoreModel -->
                                                <td><?= $scores['count_founded_pair']; ?></td>
                                                <!-- Récupération de la date à laquelle le joueur a joué grâce à la méthode définie dans ScoreModel -->
                                                <!-- formattage de la date grâce à la méthode date de php https://www.php.net/manual/fr/function.date -->
                                                <td><?= date("d-m-Y", strtotime($scores['created_at'])); ?></td>
                                            </tr>
                                        <?php
                                        $index++;
                                    }

                                    // Si il n'y a pas encore de score enregistré en bdd
                                    if ($index == 1) {
                                        ?>
                                            <tr>
                                                <td colspan="5">----- Pas encore de joueurs -----</td>
                                            </tr>
                                        <?php
                                    }
                                // Si la bdd et la table score ne sont pas créées
                                } else {
                                    ?>
                                        <tr>
                                            <td colspan="5">----- Pensez bien à créer votre bdd -----</td>
                                        </tr>
                                    <?php
                                };

                                // Fermeture de la connexion
                                $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Zone de contenu des cartes de jeu (affichage gérée en js) -->
                <div class="cards dnone"></div>

                <div class="progressbar dnone">
                    <div class="progressbar-container">
                        <div class="progressbar-item"></div>
                    </div>
                </div>

                <!-- Fenêtre modale de fin de jeu (affichage gérée en js) -->
                <aside class="endgame dnone" aria-hidden="true" role="dialog"></aside>
            </main>
        </div> <!-- /wrapper -->

        <div class="wrapper-too-short">
            <h2>Oups !</h2>
            <h3>L'écran est trop petit pour jouer... il va falloir trouver plus grand !</h3>
        </div>

        <script src="assets/js/app.js"></script>
    </body>
</html>