<?php

require 'connectDB.php';

session_start();

if (!isset($_SESSION['account_id'])) {
// Dans le cas où la session n'existe pas
}

$accountID = $_SESSION['account_id'];

$query = "SELECT username, email FROM users WHERE id=$accountID";
$req = $bdd->query($query);
$item = $req->fetchAll(PDO::FETCH_ASSOC)[0];
// SELECT de la table users pour les infos (username & mail)

$queryMessage = "SELECT messages.message, messages.date_send, users.username FROM messages INNER JOIN users ON messages.sender = users.id ORDER BY messages.date_send ASC";
$statement = $bdd->query($queryMessage);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
// SELECT des tables jointes

?>

<!DOCTYPE html>
<html lang="fr">
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
    <div class="container">
    <!--   <div class="row">
        <div class="col-md-offset-2 col-xs-10 col-md-8 column"> -->
          <a href="index.php"><img src="img/logo.png" alt="logo" class="logo-member" height="20px"></a>
  <!--       </div>
      </div> -->
      <div class="container main-member">
        <div class="row">
          <div class="col-md-3 columnNew column-profil">
            <label>Photo de profil</label>
            <img src="img/koro.png" alt="Photo profil" id="profil-picture" class="img-responsive">
            <label>Votre pseudo :</label> <br>
            <?= $item['username']; ?>
            <label>Votre adresse mail lié au compte : </label><br>
            <?= $item['email']; ?>
            <br>
            <!-- Menu dans le profil -->
            <div class="container container-settings">
              <a href="" data-toggle="modal" data-target="#modal-avatar" id="btn-avatar" class="btn btn-primary settings">
                <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Changer d'avatar
              </a>
              <a href="" data-toggle="modal" data-target="#modal-settings" id="btn-settings" class="btn btn-info settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Réglages
              </a>
              <a href="disconnect.php" id="btn-disconnect" class="btn btn-danger settings">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span> Se déconnecter
              </a>
            </div>
            
            
          </div>
          <div class="col-md-8 columnNew column-chat">
            <h2>Bienvenue sur le chat <?= $item['username']; ?> !</h2>

            <!-- BEGIN Modal Avatar-->
            <div class="modal fade" id="modal-avatar" role="dialog">
              <div class="modal-dialog">
                
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Changer votre avatar</h4>
                  </div>
                  <div class="modal-body">
                    <form action="uploadAvatar.php" method="POST" enctype="multipart/form-data">
                      <input type="file" class="form-control" name="avatar">
                      <input type="submit" class="form-control" name="btn-avatar" value="Upload">
                    </form>
                  </div>
                </div>
                
              </div>
            </div>
            <!-- END Modal Avatar-->

            <!-- BEGIN Modal Settings-->
            <div class="modal fade" id="modal-settings" role="dialog">
              <div class="modal-dialog">
                
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Changer votre avatar</h4>
                  </div>
                  <div class="modal-body">
                    <form action="#" method="POST">
                      <div class="form-group">
                        <input type="text" name="newPseudo" class="form-control" placeholder="Nouveau pseudo">
                        <br>
                        <input type="email" name="newEmail" class="form-control" placeholder="Changement adresse email">
                        <br>
                        <input type="email" name="newEmail-confirm" class="form-control" placeholder="Confirmation adresse email">
                        <br>
                        <button type="submit" name="newBtn" id="newBtn-id" class="btn btn-success">Enregistrer les modifications</button>
                      </div>
                    </form>
                  </div>
                </div>
                
              </div>
            </div>
            <!-- END Modal Settings-->
            
            <div class="col-xs-12 col-md-12  chat" id="bubble">
              <!-- Equivalent de la bulle de message, c'est celle-ci dans lequel on écrit -->
              <?php

              foreach ($result as $value) {
              echo '<div class="bubble-chat">';
                echo '<span style="color:green">'.$value['username'].'</span>';
                echo '(<span style="font-style: italic">'.$value['date_send'].'</span>) dit : ';
                echo '<span style="color:black">'.$value['message'].'</span>';
              echo '</div>';
              }

              ?>
            </div>
            <div class="form-group">
              <!-- Input pour le message et son bouton -->
              <input type="text" class="form-control" name="msg-tosend" id="msg-tosend-id">
              <button type="submit" class="btn btn-success" id="btn-send" onclick="sendMsg();">Envoyer</button>
            </div>
          </div>
          <div class="col-md-2 columnNew">
          </div>
        </div>
        
      </div>
      <div class="container-online-users">
        <!-- Voir qui est connecté -->
      <div class="title-users">Qui est en ligne ?</span>
      
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Inclus script jQuery -->
    <script src="js/jQuery.js"></script>
    <script>
    function getXHR() {
    // On check le browser pour AJAX
    var xhr = null;
    if (window.XMLHttpRequest) {
    xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObjet) {
    try {
    xhr = new ActiveXObjet("Msxml2.XMLHTTP");
    }
    catch(e)
    {
    xhr = new ActiveXObjet("Microsoft.XMLHTTP");
    }
    }else {
    alert("Dll another browser");
    xhr = false;
    }
    return xhr;
    }
    function sendMsg() {
    // Fonction AJAX
    var xhr = getXHR();
    var msg = document.getElementById("msg-tosend-id").value;
    
    xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
    console.log(msg);
    document.getElementById("bubble").innerHTML = this.responseText;
    }
    };
    xhr.open("POST", "sendMessage.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("msg-tosend=" + msg);
    }
    </script>
  </body>
</html>