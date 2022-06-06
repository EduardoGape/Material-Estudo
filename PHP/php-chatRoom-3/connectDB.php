<?php

$dbHost = "localhost";
$dbName = "chat_ajax";
$dbUser = "root";
$dbPassword = "user";

try 
{
	$bdd = new PDO("mysql:host=".$dbHost.";dbname=".$dbName.";charset=UTF8", $dbUser, $dbPassword);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

?>
