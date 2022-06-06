<?php

require 'connectDB.php';

session_start();

$email = $_POST["email"];
$password = sha1($_POST["password"]);

$query = $bdd->prepare("SELECT id FROM users WHERE email= :email AND password= :password");
$req = $query->execute(array("email" => $email, "password" => $password));
$result = $query->fetchAll(PDO::FETCH_OBJ);
// FETCH_OBJ retourne un objet
// FETCH_ASSOC retourne un tableau associatif

if (count($result) > 0) {
	echo "oui";
	$_SESSION['account_id'] = $result[0]->id;
	header("Location: member.php");
}
else {
	echo "non";
}

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
		<?php echo "Le membre est connecté!"; ?>
	</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script> 
  </body>
</html>