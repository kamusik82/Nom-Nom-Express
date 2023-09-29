<html>
<head>
<title>Logout Page</title>
</head>
<body>
<?php
  session_start();
  session_destroy();
  echo "<h3>You have logged out!</h3>";
  echo "To log back in go to: <a href='./login.php'>LOGIN</a>";
?>

</body>
</html>