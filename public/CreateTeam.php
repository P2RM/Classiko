<?php
//Page qui permet de créer son équipe
require_once '../src/Playersmanager.php';
$teamsManager = new TeamsManager();

if($_SERVER["REQUEST_METHOD"]== "POST"){
    $name= $_POST["name"];
    $nbPlayers= $_POST["nbPlayers"];
    $descr= $_POST["descr"];
    $sport= $_POST["sport"];


$team = new Team (
    $name,
    $nbPlayers,
    $descr,
    $sport,
);

$errors = $team->validate();
if(empty($errors)){
    $teamId = $teamsManager->addTeam($team);
    header("Location: index.php");
    exit();
}
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Crée une nouvelle équipe :</title>

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
    <h1>Crée ton équipe</h1>
    <p><a href="index.php">Retour à l'accueil</a></p>
    <p>Utilise cette page pour créer ton équipe.</p>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
        <?php if (empty($errors)) { ?>
            <p style="color: green;">L'équipe à été créée avec succès.'</p>
        <?php } else { ?>
            <p style="color: red;">Oups, il y a quelque chose qui ne va pas :</p>
            <ul>
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>
    <?php } ?>

    <form action="createPlayer.php" method ="POST">
        
        <label for="name">Nom de l'équipe :</label><br>
        <input type="text" id="name" name="name" value="<?php if (isset($name)) echo htmlspecialchars($name); ?>" minlength="2" maxlength="100">

        <br>

        <label for="surname">Nom :</label><br>
        <input type="text" id="surname" name="surname" value="<?php if (isset($surname)) echo htmlspecialchars($surname); ?>" required minlength="2" maxlength="40">

        <br>

        <label for="descr">Description :</label><br>
       <textarea name="descr" id="descr" rows ="4" cols="50" ><?php if (isset($descr)) echo htmlspecialchars($descr); ?> </textarea>

        <br>

        <label for="club">Club :</label><br>
        <input type="text" id="club" name="club" value="<?php if (isset($club)) echo htmlspecialchars($club); ?>" required minlength="2" maxlength="100">

        <br>

        <label for="sport">Type de sport :</label><br>
        <input type="text" id="sport" name="sport" value="<?php if (isset($sport)) echo htmlspecialchars($sport); ?>" required>

        <br>

        <button type="submit">Créer</button><br>
        <button type="reset">Réinitialiser</button>
    </form>

</body>
</html>