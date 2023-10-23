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

	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'Please enter your email address.';
	} else {
		$r_email = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}

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
	} else if (strtoupper($_POST['province']) != 'BC') {
		$errors[] = 'We currently only deliver in BC.';
	} else {
		$r_prov = mysqli_real_escape_string($dbc, trim($_POST['province']));
	}

	// Check for a valid postal code:
	if (empty($_POST['postal'])) {
		$errors[] = 'Please enter your postal code.';
		// } else if (preg_match("/[a-z][0-9][a-z][0-9][a-z][0-9]/i", $_POST['postal']) == 0) {
		//     $errors[] = 'Please enter a valid postal code.';
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
		} else if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Your password did not match the confirmed password.';
		} else {
			$r_password = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		}
	} else {
		$errors[] = 'Please enter a password.';
	}

	if (empty($errors)) { // If everything's OK.
		// Register the user in the database...

		$sql_insert = @"INSERT INTO users (first_name, last_name, street_1, street_2, city, province, postal, email, phone, username, password, role, privacy, reg_date) VALUES (CONCAT(UPPER(SUBSTRING('$r_fname',1,1)),LOWER(SUBSTRING('$r_fname',2))), CONCAT(UPPER(SUBSTRING('$r_lname',1,1)),LOWER(SUBSTRING('$r_lname',2))), '$r_street1', '$r_street2', CONCAT(UPPER(SUBSTRING('$r_city',1,1)),LOWER(SUBSTRING('$r_city',2))), UPPER('$r_prov'), UPPER('$r_postal'), '$r_email', '$r_phone', '$r_username', SHA1('$r_password'), 'U', 'Y', now());";
		$result = @mysqli_query($dbc, $sql_insert); // Run the query.

		if ($result) { // If it ran OK.

			// Print a message:
			// 	echo '<h1>Thank you!</h1>
			// <p>You are now registered. </p><p><br></p>
			// <a class="btn btn-primary" href="../../index.php">Ok</a>';

			$sql = "SELECT user_id, username from users where username='$r_username';";
			$result = @mysqli_query($dbc, $sql);
			$row = mysqli_fetch_array($result);
			$_SESSION['user_id'] = $row["user_id"]; // store user_id to the session
			$_SESSION['user_name'] = $row["username"]; // store username to the session

			header("Location: ../../index.php"); // go to main page
			exit();

		} else { // If it did not run OK.

			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';

			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br><br>Query: ' . $sql_insert . '</p>';

		} // End of if ($r) IF.

		// mysqli_close($dbc); // Close the database connection.


	} else { // Report the errors.

		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br>';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br>\n";
		}
		echo '</p><p>Please try again.</p><p><br></p>';

	} // End of if (empty($errors)) IF.

	// mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title> Registration </title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<link href="../css/style.css" rel="stylesheet">
</head>

<body>
	<div class="v-center">

		<form action="registration.php" method="POST" class="my-2">
	
			<div class="background mx-5 mb-5 pb-2 rounded">
				<h3 class="mt-5 pt-3 ps-5">New User Registration Form</h3>
				<h6 class="ps-5 pb-3">fields with * are required</h6>
	
				<div class="container text-center my-1">
					<div class="row text-start">
						<h5>User Details:</h5>
					</div>
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="reg_fname" placeholder="First Name"
									name="first_name" value="<?php if (isset($_POST['first_name']))
										echo $_POST['first_name']; ?>">
								<label for="reg_fname">First Name *</label>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="reg_lname" placeholder="Last Name"
									name="last_name" value="<?php if (isset($_POST['last_name']))
										echo $_POST['last_name']; ?>">
								<label for="reg_lname">Last Name *</label>
							</div>
						</div>
						<div class="col-12">
							<div class="form-floating mb-3">
								<input type="email" class="form-control" id="reg_email" placeholder="name@example.com"
									name="email" value="<?php if (isset($_POST['email']))
										echo $_POST['email']; ?>">
								<label for="reg_email">Email address *</label>
							</div>
						</div>
						<div class="col-12">
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="reg_phone" placeholder="5551239876" name="phone"
									value="<?php if (isset($_POST['phone']))
										echo $_POST['phone']; ?>">
								<label for="reg_phone">Phone Number</label>
							</div>
						</div>
					</div>
				</div>
	
				<div class="container text-center my-1">
					<div class="row text-start">
						<h5>Delivery Address:</h5>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="reg_street1" placeholder="Street Address"
									name="address_1" value="<?php if (isset($_POST['address_1']))
										echo $_POST['address_1']; ?>">
								<label for="reg_street1">Street Address 1 *</label>
							</div>
						</div>
						<div class="col-12">
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="reg_street2" placeholder="Street Address"
									name="address_2" value="<?php if (isset($_POST['address_2']))
										echo $_POST['address_2']; ?>">
								<label for="reg_street2">Street Address 2 *</label>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="reg_city" placeholder="City" name="city" value="<?php if (isset($_POST['city']))
									echo $_POST['city']; ?>">
								<label for="reg_city">City *</label>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="reg_prov" placeholder="Province" name="province"
									value="<?php if (isset($_POST['province']))
										echo $_POST['province']; ?>">
								<label for="reg_prov">Province *</label>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="reg_postal" placeholder="Postal Code"
									name="postal" value="<?php if (isset($_POST['postal']))
										echo $_POST['postal']; ?>">
								<label for="reg_postal">Postal Code *</label>
							</div>
						</div>
					</div>
				</div>
	
				<div class="container text-center my-1">
					<div class="row text-start">
						<h5>Login Credentials:</h5>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="reg_username" placeholder="Username"
									name="username" value="<?php if (isset($_POST['username']))
										echo $_POST['username']; ?>">
								<label for="reg_username">Username *</label>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-floating mb-3">
								<input type="password" class="form-control" id="reg_pass1" placeholder="Password"
									name="pass1" value="<?php if (isset($_POST['pass1']))
										echo $_POST['pass1']; ?>">
								<label for="reg_pass1">Password *</label>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-floating mb-3">
								<input type="password" class="form-control" id="reg_pass2" placeholder="Confirm Password"
									name="pass2" value="<?php if (isset($_POST['pass2']))
										echo $_POST['pass2']; ?>">
								<label for="reg_pass2">Confirm Password *</label>
							</div>
						</div>
					</div>
				</div>
			</div>
	
			<a class="btn btn-secondary ms-5" href="../../index.php">Cancel</a>
			<input type="submit" class="btn btn-primary" name="submit_registration" value="REGISTER">
	
		</form>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
		crossorigin="anonymous"></script>
</body>

</html>