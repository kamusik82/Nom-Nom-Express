<?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (!empty($_POST['username']) && !empty($_POST['pass'])){
        
            // pass form fields into variables
            $username = $_POST['username'];
            $password = $_POST['pass']; 
    
            // search username and password pair in the database
            $sql = "select user_id, username, password, role from users where username = '$username' and password = SHA1('$password');";
            $result = mysqli_query($dbc,$sql);
            $num = mysqli_num_rows($result); // Count the number of row.
    
            // error message variable
            $creds = '';
    
            // if there is a returned row
            if ($num == 1){
                $row = mysqli_fetch_array($result);

                $_SESSION['user_id'] = $row['user_id']; // store user_id to the session
                $_SESSION['user_name'] = $row['username']; // store username to the session
                $_SESSION['role'] = $row['role']; // users role used in index as well as here
                
                // go to admin or customer page depending on a returned role
                if ($_SESSION['role'] == 'A') {
                    header('Location: ./admin.php');  // go to admin page 
                } else {
                    header('Location: ./index.php'); // go to customer page
                }
    
                exit;
            } else {
                $creds = 'Invalid Credentials';
                print '<p style="color: red;">' .$creds. '</p>';    // print error message underneath form if credentials are wrong
            }
            
        }
        
    }
?>