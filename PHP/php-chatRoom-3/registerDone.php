<?php

require 'connectDB.php';

$username = $_POST["pseudo"];
$email = $_POST["email"];
$password = sha1($_POST["password"]);

$query = $bdd->query('SELECT * FROM users');
$arrayDonnees = array();

if (isset($_POST["pseudo"]) && isset($_POST["email"]) && isset($password)) {
$sql = ('INSERT INTO users(username, email ,password) VALUES ('.$bdd->quote($_POST['pseudo']).','.$bdd->quote($_POST['email']).','.$bdd->quote($password).')');
$prep = $bdd->prepare($sql);
$prep->execute();
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Garamail</title>
    <meta charset="utf-8">
    <meta name="description">
    <meta name="keywords">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" charset="utf-8">
  </head>
  <body>
    <div class="container main">
      <h1 class="page-title">Bienvenue sur Garamail</h1>

      <div class="thumbnail main-connect">
        <p>Vous avez bien été enregistré</p>
        <a href="index.php"><button type="button" class="btn btn-primary">Retourner à l'accueil</button></a>
      </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>