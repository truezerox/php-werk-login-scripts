<?php

/*
 * PDO Database connection, can be placed in separate file
 * Documentation: http://php.net/manual/en/pdo.connections.php
 * */

$db = new PDO('mysql:host=HOST;dbname=DATABASENAME', 'USERNAME', 'PASSWORD');
/*
 * Verify if a username is already taken,
 * Used PDO instead of the deprecated mysql_* function used in previous code
 * Documentation PDO::PREPARE http://php.net/manual/en/pdo.prepare.php
 * documentation PDO::execute
 *
 * */
$getUser = $db->prepare("SELECT * FROM clients WHERE username = :username ");
$getUser->execute(array(":username" => $_POST["username"]));//This will return false if query failed
/*
 * Check if rowcount is above 0, if so the username is taken
 * */
if($getUser->rowCount() == 1) {
    echo "That username has been taken.";
} else if(!preg_match('/^[a-zA-Z0-9]+$/', $_POST["username"])) {// If our username is invalid
    echo "The username can only contain letters or numbers."; // Tell the user

    /*
     * Previous code used deprecated function, switched to PHP's filter_var()
     * Documentation: http://php.net/manual/en/function.filter-var.php
     * */
} else if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false) {
    echo "The email or PayPal address you entered is invalid."; // Tell the user
} else {


    /*
     * Previous code used MD5, which is flawed. Read this why:
     * - https://www.sitepoint.com/why-you-should-use-bcrypt-to-hash-stored-passwords/
     * - http://stackoverflow.com/a/30949746/1604068
     * - http://security.stackexchange.com/a/5691/105284
     *
     * Documentation php.net/manual/en/function.password-hash.php for password_hash() and password_verify()
     */

    $createUser = $db->prepare("INSERT INTO clients (:username, :password, :email, :bank)");
    $createCheck = $createUser->execute(array(
        ":username"     => $_POST["username"],
        ":password"     => password_hash($_POST['password'], PASSWORD_DEFAULT),
        ":email"        => $_POST['email'],
        ":bank"         => $_POST['bank']
    ));

    /*
     * Check if user actually has been created
     * */
    if($createCheck == false)
    {
        throw new Exception('Failed to create user '.$createUser->errorInfo());
    }
    echo "Thank you for signing up.";

}

?>
