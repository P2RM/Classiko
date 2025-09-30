<?php
require '../src/PlayersManager.php';

$playersManager = new PlayersManager();

// On vérifie si l'ID de l'animal est passé dans l'URL
if (isset($_GET["id"])) {
    // On récupère l'ID de l'animal de la superglobale `$_GET`
    $playerId = $_GET["id"];

    // On récupère l'animal correspondant à l'ID
    $player = $playersManager->getPlayer($playerId);

    // Si l'animal n'existe pas, on redirige vers la page d'accueil
    if (!$player) {
        header("Location: index.php");
        exit();
    } else {
        // Sinon, on initialise les variables
        $id = $player['id'];
        $name = $player['name'];
        $surname = $player['surname'];
        $country = $player['country'];
        $club = $player['club'];
        $position = $player['position'];
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gère la soumission du formulaire

    // Récupération des données du formulaire
    $id = $_POST["id"];
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $country = $_POST["country"];
    $club = $_POST["club"];
    $position = $_POST["position"];

    // On crée un nouvel objet `Pet`
    $player = new Player(
        $name,
        $surname,
        $country,
        $club,
        $position,
    );

    // On valide les données
    $errors = $player->validate();

    // S'il n'y a pas d'erreurs, on met à jour l'animal
    if (empty($errors)) {
        // On met à jour l'animal dans la base de données
        $success = $playersManager->updatePlayer($id, $player);

        // On vérifie si la mise à jour a réussi
        if ($success) {
            // On redirige vers la page de l'animal modifié
            header("Location: view.php?id=$id");
            exit();
        } else {
            // Si la mise à jour a échoué, on affiche un message d'erreur
            $errors[] = "La mise à jour a échoué.";
        }
    }
} else {
    // Si l'ID n'est pas passé dans l'URL, on redirige vers la page d'accueil
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Modifie un joueur| Gestionnaire de joueurs</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #444;
        }

        p {
            text-align: center;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="color"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="radio"],
        input[type="checkbox"] {
            margin-right: 5px;
        }

        input[type="radio"]+label,
        input[type="checkbox"]+label {
            display: inline-block;
            margin-right: 15px;
        }

        fieldset div {
            display: inline-block;
            margin-right: 10px;
        }

        fieldset {
            margin-top: 5px;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        legend {
            font-weight: bold;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #4cae4c;
        }

        a {
            color: #5cb85c;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Modifie un joueur</h1>
    <p><a href="index.php">Retour à l'accueil</a></p>
    <p>Utilise cette page pour modifier un joueur.</p>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
        <?php if (empty($errors)) { ?>
            <p style="color: green;">Le formulaire a été soumis avec succès !</p>
        <?php } else { ?>
            <p style="color: red;">Le formulaire contient des erreurs :</p>
            <ul>
                <?php foreach ($errors as $error) { ?>
                    <li><?= $error; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>
    <?php } ?>

    <form action="createPlayer.php" method ="POST">
        
        <label for="name">Prénom :</label><br>
        <input type="text" id="name" name="name" value="<?php if (isset($name)) echo htmlspecialchars($name); ?>" minlength="2" maxlength="40">

        <br>

        <label for="surname">Nom :</label><br>
        <input type="text" id="surname" name="surname" value="<?php if (isset($surname)) echo htmlspecialchars($surname); ?>" required minlength="2" maxlength="40">

        <br>

        <label for="country">Pays :</label><br>
        <input type="text" id="country" name="country" value="<?php if (isset($country)) echo htmlspecialchars($country); ?>" minlength="2" maxlength="40">

        <br>

        <label for="club">Club :</label><br>
        <input type="text" id="club" name="club" value="<?php if (isset($club)) echo htmlspecialchars($club); ?>" required minlength="2" maxlength="100">

        <br>

        <label for="position">Position :</label><br>
        <input type="texte" id="position" name="position" value="<?php if (isset($position)) echo htmlspecialchars($position); ?>" required>

        <br>
        
        <a href="delete.php?id=<?= htmlspecialchars($pet["id"]) ?>">
            <button type="button">Supprimer</button>
        </a><br>
        <button type="submit">Mettre à jour</button><br>
        <button type="reset">Réinitialiser</button>
    </form>
</body>

</html>

</head>