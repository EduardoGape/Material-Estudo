<?php

require 'connectDB.php';
session_start();

session_destroy();

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
          <img src="img/logo.png" alt="logo" >

          <p>À bientôt !</p>

       	 <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>
        </div>

    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script> 
  </body>
</html>