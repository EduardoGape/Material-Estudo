<?php

require 'connectDB.php';

$username = $_POST["pseudo"];
$email = $_POST["email"];
$password = sha1($_POST["password"]);

$query = $bdd->query('SELECT * FROM users');
$arrayDonnees = array();

?>

<!DOCTYPE html>
<html>
  <head>
  <title>Chat</title>
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
      <?php
        
        foreach ($arrayDonnees as $key => $value) {
          echo $value["username"];
        }

      ?>

        <div class="thumbnail main-connect">
          <form action="registerDone.php" method="POST">
          <a href="index.php"><img src="img/logo.png" alt="logo" id="logo"></a>
            <h3>Inscription</h3>
            <div class="form-group">
              <label>Pseudo</label>
              <br>
              <input type="text" class="form-control" placeholder="Pseudo" name="pseudo" id="pseudo-id">
            </div>
            <div class="form-group">
              <label>Adresse e-mail</label>
              <br>
              <input type="text" class="form-control" placeholder="Adresse e-mail" name="email" id="email-id">
            </div>
            <div class="form-group">
              <label>Mot de passe</label>
              <br>
              <input type="password" class="form-control" placeholder="Mot de passe" name="password" id="password-id">
            </div>
            <div class="form-group">
              <label>Confirmation du mot de passe</label>
              <br>
              <input type="password" class="form-control" placeholder="Confirmation du mot de passe" name="confirm-password" id="confirm-password-id">
            </div>
            <button type="submit" id="subscribe-btn" class="btn btn-success">S'inscrire</button>
          </form>
          <br>
          <div class="caption">
          </div>
        </div>

    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script> 
  </body>
</html>