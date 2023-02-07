<?php
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
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>HTML Form</h1>
    <!-- html form to take information -->
    <form method="post" action="handle_form.php" enctype="multipart/form-data">
        Name: <input type="text" name="name" required pattern="[A-Za-z]*"
            oninvalid="this.setCustomValidity('Enter alphabets only')" oninput="this.setCustomValidity('')"><br><br />
        Last Name: <input type="text" name="lname" pattern="[A-Za-z]*"
            oninvalid="this.setCustomValidity('Enter alphabets only')" oninput="this.setCustomValidity('')"><br />
        <br />
        Full Name:
        <input type="text" name="fullname" readonly>
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
        <label for="number">Phone Number :</label>
        <select name="phone_prefix">
            <option value="+91">+91</option>
        </select>
        <input type="tel" id="phone" name="number">
        <br />
        <br />
        <label for="email">Email:</label>
        <input type="text" id="email" name="email">
        <br />
        <br />
        <input type="submit" value="submit" name="submit">


    </form>

</body>

</html>