<?php 
    // initialize variables
    $username = $pass = $userErr = $passErr = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // checks if the username field is empty
        if (empty($_POST["username"])) { 
            $userErr = "*Please enter a username";  // username error if empty
        } else {
            $userErr = "";  // reset username error if not empty
        }

        //checks if the password field is empty
        if(empty($_POST["pass"])){
            $passErr = "*Please enter a Password"; // password Error if empty
        } else {
            $passErr = "";  // reset password error if not empty
        }

    }
?>