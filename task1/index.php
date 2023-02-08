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
echo "Connected successfully";
$name = $lname = $fullName = "";
if (empty($_POST['name']) && empty($_POST['lname'])) {

    echo " <br/> Please fill in the fields";

} else {
    $name = $_POST['name'];
    $lname = $_POST['lname'];
    $fullName = $name . " " . $lname;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>HTML Form</h1>
    <form method="post" action="index.php">
        Name: <input type="text" name="name" required pattern="[A-Za-z]*"
            oninvalid="this.setCustomValidity('Enter alphabets only')" oninput="this.setCustomValidity('')"><br><br />
        Last Name: <input type="text" name="lname" pattern="[A-Za-z]*"
            oninvalid="this.setCustomValidity('Enter alphabets only')" oninput="this.setCustomValidity('')"><br />
        <br />
        Full Name:
        <input type="text" name="fullname" readonly value="<?php $fullname = $name . " " . $lname;
        echo "$fullName"; ?>">
        <br />
        <br />
        <input type="submit" value="submit">
        <?php
        if ($fullName == "") {

        } else {
            echo "<h1>Tumhara Naam $fullName hain</h1>";
        }

        ?>
    </form>

</body>

</html>