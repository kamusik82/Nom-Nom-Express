<?php 
    if (!empty($_POST['username']) && !empty($_POST['pass'])){
    
        // pass form fields into variables
        $username = $_POST['username'];
        $password = $_POST['pass']; 

        // error message variable
        $creds = "";

        if($username == "Manny" && $password == "12345"){
            header("Location: ../../admin.php");  // go to admin page if credentials are correct
            exit;
        } else {
            $creds = 'Invalid Credentials';
            print '<p style="color: red;">' .$creds. '</p>';    // print error message underneath form if credentials are wrong
        }
        
    }
?>