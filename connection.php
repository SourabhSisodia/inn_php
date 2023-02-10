<?php
$username = "root";
$password = "";
$db = "form_data";

// Connection
$conn = new mysqli(
    "localhost",
    $username,
    $password,
    $db
);

// For checking if connection is
// successful or not
if ($conn->connect_error) {
    die("Connection failed: "
        . $conn->connect_error);
}

?>