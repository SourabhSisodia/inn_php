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

        echo "$ans->can_connect_smtp";
        // checks if the mail is valid
        if (isset($ans->can_connect_smtp)) {
            // checks if the mail exists or not
            if ($ans->can_connect_smtp) {
            } else {
                header("Location: ./index.php?message=synatx_valid_but_mail_does_not_exists");
            }
        } else {
            header("Location: ./index.php?message=mail_synatx_not_valid");
        }

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

        $data = $_POST;

        // Create the first copy of the data in a doc format
        $server_file = "./docs/$fullName.doc";
        $server_content = "Form Data\n";
        $server_content .= "Name : " . $fullName . "\n";
        $server_content .= "Email : " . $email . "\n";
        $server_content .= "Phone : " . $phone_number . "\n";
        $server_content .= "Subject  Marks" . "\n";
        foreach ($marks as $key => $value) {
            // outputs table row as subject => marks
            $server_content .= "$key  $value" . "\n";
        }
        file_put_contents($server_file, $server_content);

        // Create the second copy of the data in a doc format





        // Check if the file exists
        if (file_exists($server_file)) {
            // Set the headers to trigger a download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($server_file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($server_file));

            // Output the file content
            readfile($server_file);
            exit;
        } else {
            // Handle the error
            echo "The file does not exist.";
        }



    }
}
?>


<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=Windows-1252">
</head>




</html>