<?php

require 'connectDB.php';

session_start();

if (!isset($_SESSION['account_id'])) {
  // Dans le cas où la session n'existe pas
}

$accountID = $_SESSION['account_id'];

$avatar = $_FILES["myavatar"]["name"];

$avatarTmp = addslashes(file_get_contents($_FILES["myavatar"]["tmp_name"]));

$req = $bdd->prepare('INSERT INTO users(avatar) VALUES (?,?)');
$req->execute(array($avatar, $avatarTmp));

?>