<?php
    // Récupération des données envoyées en POST
    // trim permet de supprimer les espaces en début et en fin de chaîne https://www.php.net/manual/fr/function.trim.php
    // htmlspecialchars convertit les caractères spéciaux en entités HTML https://www.php.net/manual/fr/function.htmlspecialchars.php
    // Même si un contrôle des données est déjà fait par le front, il est INDISPENSABLE de recontrôler les données en back car on ne fait jamais confiance aux données envoyées par le front (possibilité de hacking)
    // On vérifie que chaque variable est bien remplie (sinon on s'en charge) pour éviter les erreurs lors de l'insertion en bdd - si la bdd impose qu'un champ ne soit pas null et que la variable est null alors cela renverra une erreur, on s'affranchit de ça ici
    $name = isset($_POST['pseudo']) ? trim(htmlspecialchars($_POST['pseudo'])) : '';
    $duration = isset($_POST['duration']) ? $_POST['duration'] : 0;
    $count_founded_pair = isset($_POST['count_founded_pair']) ? $_POST['count_founded_pair'] : 0;
    $count_error = isset($_POST['count_error']) ? $_POST['count_error'] : 0;


    // Création de la connexion
    $conn = new mysqli("mysql", "root", "dockertest", "memory");
    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Préparation de la requête et binding
    $stmt = $conn->prepare("INSERT INTO `score` (`name`, `duration`, `count_founded_pair`, `count_error`) VALUES (?, ?, ?, ?)");

    // En premier paramètre, on indique le type de données que l'on va passer
    // s => string
    // i => integer
    // d => double
    $stmt->bind_param("siii", $name, $duration, $count_founded_pair, $count_error);

    // Execution de la requête
    $stmt->execute();

    // Fermeture du statement et de la connexion
    $stmt->close();
    $conn->close();

    // Création du tableau de réponse à envoyer au front
    $response = [
        'success' => true,
    ];

    // Précision au navigateur que la réponse est en JSON
    header('Content-Type: application/json');
    // Affichage de la version encodée en JSON du tableau associatif
    // http://php.net/json_encode
    // JSON_PRETTY_PRINT => pour formater le code afin qu'un humain le comprenne
    echo json_encode($response, JSON_PRETTY_PRINT);
