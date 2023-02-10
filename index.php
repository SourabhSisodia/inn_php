<?php
// starts the session
session_start();

// if session variable is set then the user should get redirected to welcome.php
if (isset($_SESSION["user"])) {
    header("Location:./welcome.php");
}

// get the error message and displays it
if (!empty($_GET['message'])) {
    $message = str_replace("_", " ", $_GET['message']);
    echo "<p style ='color:red;'>$message</p>";
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
    <form action="handle_form.php" method="post">
        <Label for="email">Email:</Label>
        <input type="email" name="email" id="email">
        <br>
        <br>
        <Label for="password">Password</Label>
        <input type="password" name="password" id="password">
        <br>
        <br>
        <button type="submit">Submit</button>
    </form>
</body>

</html>