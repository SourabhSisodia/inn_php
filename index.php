<?php

// 
include "connection.php";
$name = $lname = $fullName = "";
if (isset($_POST["submit"])) {


    if (
        !isset($_POST['name']) && !isset($_POST['lname']) && !isset($_POST['fileImg']) && !isset($_POST
        ['marks'])
    ) {

        echo " <br/> Please fill in the fields";

    } else {
        $name = $_POST['name'];
        $lname = $_POST['lname'];
        $unextracted_marks = explode("\n", $_POST['marks']);

        // getting marks in the format subject=>marks
        foreach ($unextracted_marks as $mark) {
            $pos = strpos($mark, "|");
            $marks[substr($mark, 0, $pos)] = substr($mark, $pos + 1);
        }

        // cocatenate the full name
        $fullName = $name . " " . $lname;

        // get the file temp, file extension , make the file name and move to the local photos folder
        $file_tmp = $_FILES["fileImg"]["tmp_name"];
        $type = $_FILES["fileImg"]["type"];
        $type = substr($type, strpos($type, "/") + 1);
        $file_name = $name . $lname . "." . $type;
        $file_path = "./photos/" . $file_name;
        move_uploaded_file($file_tmp, $file_path);

        // sql quey to insert data into form_data table
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
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>HTML Form</h1>
    <!-- html form to take information -->
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
        <label for="marks">Enter Marks:</label>

        <textarea id="marks" name="marks" rows="5" cols="50" style="display:block; color:black"
            placeholder="Enter Marks in the format English|80 and one subject in each line" required></textarea>
        <br />
        <br />
        <input type="submit" value="submit" name="submit">


    </form>
    <?php
    if (empty($fullName) || empty($marks) || empty($file_tmp)) {

    } else {

        ?>
        <!-- displays the uploaded image -->
        <img src="<?php echo
            "$file_path" ?>" alt="" srcset="" style="display:block;width:600px;height:300px; margin-top:10px;">
        <?php
        //  displays the entered full name
        echo "
            <h1>Tumhara Naam $fullName hain</h1>";
        ?>
        <table id="marks_table">
            <tr>
                <td>Subject</td>
                <td>Marks</td>
            </tr>
            <?php
            foreach ($marks as $key => $value) {
                // outputs table row as subject => marks
                echo "<tr><td>$key</td><td>$value</td></tr>";
            }
            ?>
        </table>
        <?php

    }

    ?>
</body>

</html>