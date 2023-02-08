<?php

// connection to database
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
        $phone_prefix = $_POST["phone_prefix"];
        $number = $_POST["number"];
        $email = $_POST["email"];
        $phone_number = $phone_prefix . $number;
        $unextracted_marks = explode("\n", $_POST['marks']);


        // check for valid email by using mailbox api
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => "https://api.apilayer.com/email_verification/{$email}",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: text/plain",
                    "apikey: 4YSlbf7M0iAsa89QmkMHDWMfYgYDqSAo"
                ),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET"
            )
        );


        $response = curl_exec($curl);

        curl_close($curl);

        // decode the json response to php object
        $ans = json_decode($response);

        //checks if the mail is valid
        if (isset($ans->can_connect_smtp)) {
            // checks if the mail exists or not
            if ($ans->can_connect_smtp) {
            } else {
                header("Location: ./index.php?message=email_does_not_exists");
            }
        } else {
            header("Location: ./index.php?message=mail_not_valid_please_enter_valid_mail");
        }
        // $response = substr($response, 1, strlen($response) - 3);

        // $lines = explode(",", $response);
        // $arr;
        // foreach ($lines as $line) {
        //     $key = explode(":", $line);
        //     $arr[$key[0]] = $key[1];
        // }
        // // print_r($arr);

        // print_r($arr['can_connect_smtp']);
        // // if (!isset($arr["can_connect_smtp"]) && !isset($arr["syntax_valid"])) {
        // //     header("Location: ./index.php?message=mail_not_valid_please_enter_valid_mail");
        // // }
        //check if phone number is correct or not 
        if (strlen($number) != 10) {
            header("Location: ./index.php?message=phone_number_not_valid");
        }

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
        $insertquery = "INSERT INTO `form`(`first name`, `last name`, `full name`, `image`,`phone number`,`email`) VALUES ('$name','$lname','$fullName','$file_path','$phone_number','$email')";
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
    <?php
    if (empty($fullName) || empty($marks) || empty($file_tmp) || empty($email)) {

    } else {

        ?>
        <!-- displays the uploaded image -->
        <img src="<?php echo
            "$file_path" ?>" alt="" srcset="" style="display:block;width:600px;height:300px; margin-top:10px;">
        <?php
        //  displays the entered full name
        echo "
            <h1>Tumhara Naam $fullName hain</h1>";
        echo "
            <h1>Tumhara Phone Number  $phone_number hain</h1>";
        echo "
            <h1>Tumhara Email $email hain</h1>";
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