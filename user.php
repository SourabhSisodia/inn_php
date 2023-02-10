<?php


class User
{
    private $email;
    private $password;
    private $conn;
    function __construct($email, $password, $conn)
    {
        $this->email = $email;
        $this->password = $password;
        $this->conn = $conn;
    }
    public function check_user()
    {
        // try querying sql database if successful perform operations else redirect
        try {
            $sql = "SELECT `Email`, `password` FROM `user` WHERE `Email`='$this->email';";
            $result = mysqli_query($this->conn, $sql);
        } catch (error) {
            return "error_in_database";

        }

        // check if email exists or not
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // checks if password is correct or not
            if ($this->password != $row["password"]) {
                return "cannot_login_wrong_password";


            } else {
                // sets the user variable in session and redirects to welcome page
                $_SESSION["user"] = $this->email;
                return "success";

            }


        } else {
            return "cannot_login_wrong_email_or_wrong_password";


        }

    }
}


?>