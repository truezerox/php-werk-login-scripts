<?php

//database bestand.
require('data.php');




//naam etc

$username = $_POST["username"];
$password = $_POST["password"];
$email 	  = $_POST["email"];
$bank	  = $_POST["bank"];

//invoer database.

$result= mysql_query(

					"INSERT INTO clients (clients_ID, username, password, email, bank)"
				"VALUES ('', '$username', '$password', '$email', '$bank')"
				};

	echo "Bedankt voor uw aanmelding";
				
?>