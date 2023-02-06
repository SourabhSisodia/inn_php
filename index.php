<?php
include_once("C:/xampp/htdocs/TASKS/index.php");
include "connection.php";
$name = $lname = $fullName = "";
if (isset($_POST["submit"])) {


    if (!isset($_POST['name']) && !isset($_POST['lname']) && !isset($_POST['fileImg'])) {

        echo " <br/> Please fill in the fields";

    } else {
        $name = $_POST['name'];
        $lname = $_POST['lname'];
        $fullName = $name . " " . $lname;
        $file_tmp = $_FILES["fileImg"]["tmp_name"];
        $type = $_FILES["fileImg"]["type"];
        $type = substr($type, strpos($type, "/") + 1);
        $file_name = $name . $lname . "." . $type;
        $file_path = "./photos/" . $file_name;
        move_uploaded_file($file_tmp, $file_path);
        $insertquery = "INSERT INTO `form`(`first name`, `last name`, `full name`, `image`) VALUES ('$name','$lname','$fullName','$file_path')";
        mysqli_query($conn, $insertquery);

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
    <h1>HTML Form</h1>
    <form method="post" action="index.php" enctype="multipart/form-data">
        Name: <input type="text" name="name" required pattern="[A-Za-z]*"
            oninvalid="this.setCustomValidity('Enter alphabets only')" oninput="this.setCustomValidity('')"><br><br />
        Last Name: <input type="text" name="lname" pattern="[A-Za-z]*"
            oninvalid="this.setCustomValidity('Enter alphabets only')" oninput="this.setCustomValidity('')"><br />
        <br />
        Full Name:
        <input type="text" name="fullname" readonly value="<?php
        echo "$fullName"; ?>">
        <br />
        <br />
        <input type="file" name="fileImg" required accept=".jpg,.jpeg,.png" />
        <br />
        <br />
        <label for="w3review">Review of W3Schools:</label>

        <textarea id="w3review" name="w3review" rows="4" cols="50">
At w3schools.com you will learn how to make a website. They offer free tutorials in all web development technologies.
</textarea>
        <br />
        <br />
        <input type="submit" value="submit" name="submit">


    </form>
    <?php
    if (empty($fullName)) {

    } else {

        ?>
        <img src="<?php echo
            "$file_path" ?>" alt="" srcset="" style="display:block;width:600px;height:300px; margin-top:10px;">
        <?php
        echo "
            <h1>Tumhara Naam $fullName hain</h1>";

    }

    ?>
</body>

</html>