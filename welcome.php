<?php

// starts the sessiom
session_start();

// checks if session user is set if not then redirect
if (!isset($_SESSION["user"])) {
    header("Location:./index.php?message=please_login_first");
}

// if someone clicks on logout unset the session
if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("Location:./index.php");

}

// if someone does a get query like welcome.php?q=4 then redirect to correct url
if (isset($_GET["q"])) {
    $q = $_GET["q"];
    switch ($_GET["q"]) {
        case "1":
            echo "<script> location.href='https://github.com/SourabhSisodia/inn_php/pull/$q';</script>";
            break;
        case "2":
            echo "<script> location.href='https://github.com/SourabhSisodia/inn_php/pull/$q';</script>";
            break;
        case "3":
            echo "<script> location.href='https://github.com/SourabhSisodia/inn_php/pull/$q';</script>";
            break;
        case "4":
            echo "<script> location.href='https://github.com/SourabhSisodia/inn_php/pull/$q';</script>";
            break;
        case "5":
            echo "<script> location.href='https://github.com/SourabhSisodia/inn_php/pull/$q';</script>";
            break;
        case "6":
            echo "<script> location.href='https://github.com/SourabhSisodia/inn_php/pull/$q';</script>";
            break;
        default:
            echo "Wrong url <br>";
    }
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

    <!-- list of all the tasks -->
    <a href="welcome.php?q=1">Task 1</a><br><a href="welcome.php?q=2">Task 2</a><br><a href="welcome.php?q=3">Task
        3</a><br><a href="welcome.php?q=4">Task 4</a><br><a href="welcome.php?q=5">Task 5</a><br><a
        href="welcome.php?q=6">Task
        6</a>
    <br>
    <br>

    <!-- log out button -->
    <form action="welcome.php" method="post">

        <button type="submit" name="logout">Log Out</button>
    </form>
</body>

</html>