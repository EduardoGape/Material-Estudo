<?php

require 'connectDB.php';

session_start();

$accountID = $_SESSION['account_id'];

$query = "SELECT * FROM users WHERE id=$accountID";
$req = $bdd->query($query);
$item = $req->fetchAll(PDO::FETCH_ASSOC)[0];



if (isset($_POST["msg-tosend"])) {
  $msg = $_POST["msg-tosend"];
  $sql = $bdd->prepare('INSERT INTO messages(message, sender) VALUES (?,?) ');
  $sql->execute(array($msg ,$accountID));


}

$queryMessage = "SELECT messages.message, messages.date_send, users.username FROM messages INNER JOIN users ON messages.sender = users.id ORDER BY messages.date_send ASC";
$statement = $bdd->query($queryMessage);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);



foreach ($result as $value) {
  echo '<div class="bubble-chat">';
  echo '<span style="color:green">'.$value['username'].'</span>';
  echo '(<span style="font-style: italic">'.$value['date_send'].'</span>) dit : ';
  echo '<span style="color:black">'.$value['message'].'</span>';
  echo '</div>';
}

?>
