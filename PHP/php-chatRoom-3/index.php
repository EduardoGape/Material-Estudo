<?php

require 'connectDB.php';


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

        <div class="thumbnail main-connect">
          <form action="verif.php" method="POST">
          <a href="index.php"><img src="img/logo.png" alt="logo" id="logo"></a>
          
          <h3>Rejoins le chat !</h3>
            <div class="form-group">
              <label for="login-username">Adresse e-mail</label>
              <br>
              <input type="text" class="form-control" name="email" id="login-username" placeholder="Ton adresse email">
            </div>
            <div class="form-group">
              <label for="login-password">Mot de passe</label>
              <br>
              <input type="password" class="form-control" name="password" id="login-password" placeholder="Mot de passe">
            </div>
            <button type="submit" id="connect-btn" class="btn btn-success">Se connecter</button>
          </form>
          <br>
          <div class="caption">
            <p>Pas encore membre ?</p>
            <a href="inscription.php" class="btn btn-info">Inscription</a>
          </div>
        </div>

    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script> 

        <script>
      $(document).ready(function() {

      });

    </script>
  </body>
</html>