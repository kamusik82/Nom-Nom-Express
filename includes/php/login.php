<html>
<head>
    <title> Initial Login</title>
</head>
<body>

    <!-- login page currently only used for admin login. Other Customer login implementation to come. 
         Implement using credentials include that checks for user type. When possible easy to convert into
         offcanvas or modal -->

    <?php include "./validation.php" ?> <!-- validation include to validate forms filled -->
    
    <H2> Please enter your user name and password to login: </H2>

    <form action="login.php" method="POST"> <!-- form action is to stay on the same page -->

        <p> 
            USERNAME: <input type="text" name="username" 
            value="<?php if(isset($_POST['username'])) {
                print htmlspecialchars($_POST['username']); } ?>"/> <!-- keeps the username value given and also protects against injection attacks -->
            <span><?php echo $userErr;?></span>
        </p>

        <p> 
            PASSWORD: <input type="password" name="pass" 
            value="<?php if(isset($_POST['pass'])) {
                print htmlspecialchars($_POST['pass']); } ?>"/> <!-- keeps the password value given and also protects against injection attacks -->
            <span><?php echo $passErr;?></span>
        </p>

        <input type="submit" value="SUBMIT" />      

    </form>

    <?php include "./credentials.php" ?> <!-- credentials include to make sure fields are correct before moving to different page -->

    <p><a href="redirect to registration form">Create an account</a></p> <!-- doesnt actually go anywhere yet but will redirect to registration page when implemented -->

</body>
</html>