<?php

// starts the session
session_start();
// connection to database
include "user.php";
try {
    include "connection.php";
} catch (error) {
    header("Location: ./index.php?message=error_in_database");
}

// if session variable is set then the user should get redirected to welcome.php

if (isset($_SESSION["user"])) {
    header("Location:./welcome.php");
}

// checks if email and password are filled or not else redirect to login page
if (!isset($_POST["email"]) && !isset($_POST["password"])) {
    header("Location: ./index.php?message=please_fill_all_the_fields");
}

// get $email and $password
$email = $_POST["email"];
$password = $_POST["password"];

$user = new User($email, $password, $conn);

$message = $user->check_user();

if ($message == "success") {
    header("Location: ./welcome.php");
} else {
    header("Location: ./index.php?message=$message");
}

?>