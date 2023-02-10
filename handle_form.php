<?php

// starts the session
session_start();

// connection to database
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

// try querying sql database if successful perform operations else redirect
try {
    $sql = "SELECT `Email`, `password` FROM `user` WHERE `Email`='$email';";
    $result = mysqli_query($conn, $sql);

} catch (error) {
    header("Location: ./index.php?message=error_in_database");
}

// check if email exists or not
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // checks if password is correct or not
    if ($password != $row["password"]) {
        header("Location: ./index.php?message=cannot_login_wrong_password");

    } else {
        // sets the user variable in session and redirects to welcome page
        $_SESSION["user"] = $email;
        header("Location: ./welcome.php");
    }


} else {
    header("Location: ./index.php?message=cannot_login_wrong_email_or_wrong_password");

}


?>