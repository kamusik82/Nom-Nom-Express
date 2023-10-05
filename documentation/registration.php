<?php
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Registration';

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require('connection.php'); // Connect to the db.
	$errors = []; // Initialize an error array.

	// Check for a first name more than 2-char:
	if (empty($_POST['first_name'])) {
		$errors[] = 'Please enter your first name.';
	} else if (strlen($_POST['first_name']) < 3) {
        $errors[] = 'First name must be at least 2 characters.';
    } else {
		$r_fname = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
	}

	// Check for a last name more than 2-char:
	if (empty($_POST['last_name'])) {
		$errors[] = 'Please enter your last name.';
	} else if (strlen($_POST['last_name']) < 3) {
        $errors[] = 'Last name must be at least 2 characters.';
    } else {
		$r_lname = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
	}

    // ADD VALIDATION!!
	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'Please enter your email address.';
	} else {
		$r_email = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}

    // ADD VALIDATION!!
    // grab phone:
    if (!empty($_POST['phone'])) {
        $r_phone = mysqli_real_escape_string($dbc, trim($_POST['phone']));
    }

	// Check for an address 1 at least 5-char:
	if (empty($_POST['address_1'])) {
		$errors[] = 'Please enter your street address.';
	} else if (strlen($_POST['address_1']) < 6) {
        $errors[] = 'Street address must be at least 5 characters.';
    } else {
		$r_street1 = mysqli_real_escape_string($dbc, trim($_POST['address_1']));
	}

    // grab address_2:
    if (!empty($_POST['address_2'])) {
        $r_street2 = mysqli_real_escape_string($dbc, trim($_POST['address_2']));
    }

	// Check for a city at least 2-char:
	if (empty($_POST['city'])) {
		$errors[] = 'Please enter your city.';
	} else if (strlen($_POST['city']) < 3) {
        $errors[] = 'City must be at least 2 characters.';
    } else {
		$r_city = mysqli_real_escape_string($dbc, trim($_POST['city']));
	}

	// Check for BC (only accept order in BC):
	if (empty($_POST['province'])) {
		$errors[] = 'Please enter your province.';
	} else if (UPPER($_POST['province']) != 'BC') {
        $errors[] = 'We currently only deliver in BC.';
    } else {
		$r_prov = mysqli_real_escape_string($dbc, trim($_POST['province']));
	}

    // ADD VALIDATION!!
    // Check for a valid postal code:
	if (empty($_POST['postal'])) {
		$errors[] = 'Please enter your postal code.';
	} else {
		$r_postal = mysqli_real_escape_string($dbc, trim($_POST['postal']));
	}

	// Check for a username at least 5-char:
	if (empty($_POST['username'])) {
        $errors[] = 'Please enter your username.';
    } else if (strlen($_POST['username']) < 6) {
        $errors[] = 'Username must be at least 5 characters.';
    } else {
        // check if username already taken:
        $sql_select = "SELECT username FROM users;";
        $return = @mysqli_query($dbc, $sql_select);
        $num = mysqli_num_rows($return);
        $match = 0;
        while ($row = mysqli_fetch_array($return, MYSQLI_ASSOC)) {
            //echo '<p>'.$row['username'].'</p>';
            if ($_POST['username'] == $row['username']) {
                $match += 1;
            }
        }
        if ($match > 0) {
            $errors[] = 'Entered Username is already taken.';
        } else {
    		$r_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
        }
	}

	// Check for a 6-char password and match against the confirmed password:
	if (!empty($_POST['pass1'])) {
		if (strlen($_POST['pass1']) < 7) {
            $errors[] = 'Password must be at least 6 characters.';
        } else  if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Your password did not match the confirmed password.';
		} else {
			$r_password = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		}
	} else {
		$errors[] = 'Please enter a password.';
	}

	if (empty($errors)) { // If everything's OK.
		// Register the user in the database...
		
		$sql_insert = "INSERT INTO users (first_name, last_name, street_1, street_2, city, province, postal, email, phone, username, password, role, reg_date) VALUES (CONCAT(UPPER(SUBSTRING('$r_fname',1,1)),LOWER(SUBSTRING('$r_fname',2))), CONCAT(UPPER(SUBSTRING('$r_lname',1,1)),LOWER(SUBSTRING('$r_lname',2))), '$r_street1', '$r_street2', CONCAT(UPPER(SUBSTRING('$r_city',1,1)),LOWER(SUBSTRING('$r_city',2))), UPPER('$r_prov'), UPPER('$r_postal'), '$r_email', '$r_phone', '$r_username', SHA1('$r_password'), 'U', now());";
        $result = @mysqli_query($dbc, $sql_insert); // Run the query.

        if ($result) { // If it ran OK.

			// Print a message:
			echo '<h1>Thank you!</h1>
		<p>You are now registered. </p><p><br></p>';

		} else { // If it did not run OK.

			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';

			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br><br>Query: ' . $sql_insert . '</p>';

		} // End of if ($r) IF.

		mysqli_close($dbc); // Close the database connection.

		exit();

	} else { // Report the errors.

		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br>';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br>\n";
		}
		echo '</p><p>Please try again.</p><p><br></p>';

	} // End of if (empty($errors)) IF.

	// mysqli_close($dbc); // Close the database connection.

    header("Location: ./index.php");  // go to main page
} // End of the main Submit conditional.
?>



<form action="registration.php" method="POST">

    <h1>User Registration</h1>

    <h3>User Details:</h3>
    <table>
        <tr>
            <td style="width:50%">First Name</td>
            <td style="width:50%"><input type="text" name="first_name" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>"></td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td><input type="text" name="last_name" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>"></td>
        </tr>
        <tr>
            <td>E-mail</td>
            <td><input type="text" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"></td>
        </tr>
        <tr>
            <td>Phone</td>
            <td><input type="text" name="phone" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; ?>"></td>
        </tr>
    </table>

    <h3>Delivery Address:</h3>
    <table>
        <tr>
            <td style="width:50%">Address Line 1</td>
            <td style="width:50%"><input type="text" name="address_1" value="<?php if (isset($_POST['address_1'])) echo $_POST['address_1']; ?>"></td>
        </tr>
        <tr>
            <td>Address Line 2</td>
            <td><input type="text" name="address_2" value="<?php if (isset($_POST['address_2'])) echo $_POST['address_2']; ?>"></td>
        </tr>
        <tr>
            <td>City</td>
            <td><input type="text" name="city" value="<?php if (isset($_POST['city'])) echo $_POST['city']; ?>"></td>
        </tr>
        <tr>
            <td>Province</td>
            <td><input type="text" name="province" mexlength="2" value="<?php if (isset($_POST['province'])) echo $_POST['province']; ?>"></td>
        </tr>
        <tr>
            <td>Postal Code</td>
            <td><input type="text" name="postal" value="<?php if (isset($_POST['postal'])) echo $_POST['postal']; ?>"></td>
        </tr>
    </table>
    
    <h3>Login Credentials:</h3>
    <table>
        <tr>
            <td style="width:50%">Username</td>
            <td style="width:50%"><input type="text" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="pass1" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>"></td>
        </tr>
        <tr>
            <td>Confirm Password</td>
            <td><input type="password" name="pass2" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>"></td>
        </tr>
    </table>
    <br>
    <input type="submit" name="submit_registration" value="REGISTER" />      

</form>
