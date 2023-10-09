<?php

    include "./connection.php";

    // user variables for account information
    $useName = $useFirst = $useLast = $useAdd = $useAdd2 = $useCity = $useProv = $usePost = $usePhone = $useEmail = $regDate = $privacy = "";

    $u_id = $_SESSION['user_id']; // keep session ID in a variable for convenience 
    $sql = "SELECT * from users where user_id='$u_id'; "; // get all the data from the users table
    $result = @mysqli_query($dbc, $sql);

    // if there are results fill in all there user variables 
    if($result){
        $row = @mysqli_fetch_array($result);

        $useName = $row['username'];
        $useFirst = $row['first_name'];
        $useLast = $row['last_name'];
        $useAdd = $row['street_1'];
        $useAdd2 = $row['street_2'];
        $useCity = $row['city'];
        $useProv = $row['province'];
        $usePost = $row['postal'];
        $usePhone = $row['phone'];
        $useEmail = $row['email'];
        $regDate = $row['reg_date'];

        if($row['privacy'] == 'Y'){
            $privacy = "Signed";
        } else {
            $privacy = "Not Signed";
        }
    }

    // actions for when the user either opts into the privacy policy or opts out
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["out"])) {
            $sql = "UPDATE users set privacy = 'N' where user_id = '$u_id';";
            @mysqli_query($dbc, $sql);
        }
        if (isset($_POST["in"])) {
            $sql = "UPDATE users set privacy = 'Y' where user_id = '$u_id';";
            @mysqli_query($dbc, $sql);
        }
    }
?>