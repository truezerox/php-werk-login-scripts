<?php


// script by zerox

//mysql_real_escape_string = veiligheid laten staan.
// database file.

require('data.php');

$username = $_POST["username"];
$password =$_POST["password"];
//md5 is voor encryptie
$pw		  = md5 ($password);
$email 	  = $_POST(["email"];
$bank	  =	$_POST(["bank"];


// controlle op gebruikte naam.

	$query = "SELECT * FROM clients";
	$result= mysql_query($query) or die (mysql_error()); // lijst met clienten.
	while($row = mysql_fetch_array($result)){ //voor iedere invoer controleer gebruikernaam.
			if ($row['username'] == $username){
				$usernameTaken = true;
			}else{$usernameTaken = false;}
	}
//controlle
if($usernameTaken)
{
	echo "That username has been taken.";
}

else if(!preg_match('/^[a-zA-Z0-9]+$/', $username)) // If our username is invalid
{
     echo "The username can only contain letters or numbers."; // Tell the user
}

else if(!preg_match('/^[a-zA-Z0-9]+$/', $password)) // If our password is invalid
{
     echo "The password can only contain letters or numbers."; // Tell the user
}
// If our email or PayPal addresses are invalid
else if(!eregi("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$", $email))
{
     echo "The email or PayPal address you entered is invalid."; // Tell the user
}
else{

// Inserts the data into the database
	/** @noinspection PhpDeprecationInspection */
	$result= MYSQL_QUERY(
		 "INSERT INTO clients (client_ID, username, password, email, bank)".
		 "VALUES ('', '$username', '$pw', '$email', '$bank')"
		 );
echo "Thank you for signing up.";

}

?>
