<!-- 
<html>
<head>
    <title> Initial Login</title>
</head>
<body> 
-->

    <!-- login page currently only used for admin login. Other Customer login implementation to come. 
         Implement using credentials include that checks for user type. When possible easy to convert into
         offcanvas or modal -->

<?php (include "./includes/php/validation.php"); ?> <!-- validation include to validate forms filled -->
<?php 
    //<H2> Please enter your user name and password to login: </H2>

    if(isset($_POST['username'])) {
        $userName =  htmlspecialchars($_POST['username']); 
    } else {
        $userName = "";
    }
    if(isset($_POST['pass'])) {
        $passWord = htmlspecialchars($_POST['pass']); 
    } else{
        $passWord = "";
    }

print
    '<form action="index.php" method="POST"> <!-- form action is to stay on the same page -->

        <p> 
            USERNAME: <input type="text" name="username" 
            value="'.
                $userName.'"/> <!-- keeps the username value given and also protects against injection attacks -->
            <span>'.$userErr.'</span>
        </p>

        <p> 
            PASSWORD: <input type="password" name="pass" 
            value="'.
                $passWord.'"/> <!-- keeps the password value given and also protects against injection attacks -->
            <span>'.$passErr.'</span>
        </p>

        <button type="submit" value="SUBMIT" class="btn btn-primary" />Submit</button>      

    </form>';

    include ("./includes/php/credentials.php");  // credentials include to make sure fields are correct before moving to different page

    // print '<p><a href="./includes/php/registration.php">Create an account</a></p>';

?>

<!--
</body>
</html>
-->