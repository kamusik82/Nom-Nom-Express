<html>

<head>
	<title> Admin Page </title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<style>
		table, th, td { border: 1px solid black;}
		.item_picture {width: 100%; aspect-ratio: 1/1; object-fit: cover;}
	 </style>;
</head>

<body>

	<?php include("./includes/php/connection.php"); ?> <!-- include for connection php to connect to the database -->

	<form action='./includes/php/logout.php' method='post'>
		<!-- logout button form action takes you to the logout page (will probably update to just take them back to the landing page) -->
		<input type='hidden' name='logout' value='true' />
		<input type='submit' value='Logout' /> <!-- logout submit button -->
	</form>

	<a href="./index.php"><button>Index</button></a>

	<?php include("./includes/php/store_info.php"); ?> <!-- include for the store_info -->

	<h1> Store info</h1>
	<!-- information that comes from store_info php -->
	<p>Working Hours:
		<?php print $workingHours ?>
	</p>
	<p>Store Phone Number:
		<?php print $storeNum ?>
	</p>
	<p>Store Location:
		<?php print $storeLoc ?>
	</p>
	<p>Store Email:
		<?php print $storeEmail ?>
	</p>

	<!-- button to open the update store info form -->
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#infoModal">
		Update Store information
	</button>

	<!-- modal containing the update store info form -->
	<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="infoModalLabel">Update Form</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form action="admin.php" method="POST">
						<!-- form action is the admin page to stay on the same page -->
						<p> Working hours <input type="text" name="hours"></p>
						<p> Store Phone Number <input type="text" name="phone"></p>
						<p> Store Location <input type="text" name="location"></p>
						<p> Store Email <input type="text" name="email"></p>
						<input type="submit" name="update" value="Submit" /> <!-- update submit button -->
					</form>
				</div>
			</div>
		</div>
	</div>


	<h1>Add Menu Items Form</h1>

	<?php include("./includes/php/add.php"); ?>
	<!-- include add that validates given form data and updates the database -->

	<form id="addItem" enctype="multipart/form-data" action="admin.php" method="POST">
		<!-- form action is the admin page to stay on the same page -->

		<p>
			Item Name
			<input type="text" name="name" value="<?php if (isset($_POST['name'])) {
				print htmlspecialchars($_POST['name']);
			} ?>" />
			<!-- keeps the item name value given and also protects against injection attacks -->
			<?php print $nameErr ?> <!-- error message if name is empty from add.php -->
		</p>

		<p>
			Item Description
			<input type="text" name="description" value="<?php if (isset($_POST['description'])) {
				print htmlspecialchars($_POST['description']);
			} ?>" />
			<!-- keeps the description value given and also protects against injection attacks -->
			<?php print $descErr ?> <!-- error message if description is empty from add.php -->
		</p>
		<p>
			Item Price $
			<input type="text" name="price" value="<?php if (isset($_POST['price'])) {
				print htmlspecialchars($_POST['price']);
			} ?>" />
			<!-- keeps the price value given and also protects against injection attacks -->
			<?php print $priceErr ?> <!-- error message if price is empty or not a price from add.php -->
		</p>

		<p>
			Item Category
			<select name="category"> <!-- select drop down for categories -->
				<option value="">---</option>
				<option value="1">Breakfast</option>
				<option value="2">Burgers</option>
				<option value="3">Pizza</option>
				<option value="4">Dessert</option>
				<option value="5">Beverage</option>
			</select>
			<?php print $catErr ?> <!-- error message if category is not selected from add.php -->
		</p>

		<p>
			Item Picture
			<input type="hidden" name="MAX_FILE_SIZE" value="300000" /> <!-- sets a max file size for the image -->
			<input type="file" name="pic" />
		</p>
		<?php print $fileErr ?> <!-- add a file to the form -->
		</p>
		<input type="submit" name="add" value="Submit" /> <!-- add submit button -->
	</form>

	<h1>Current Menu Items</h1>

	<?php include("./includes/php/items.php"); ?> <!-- display current items with php include -->
	<?php include("./includes/php/edit.php"); ?> <!-- edit current items with php include -->

	<!-- Confirmation Modal for delete, disable, enable-->
	<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="confirmationLabel"></h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<h6 class="confirmation-top"></h6>
					<h6 class="fs-4 confirmation-item text-center text-decoration-underline"></h6>
					<h6 class="text-end confirmation-bottom"></h6>
				</div>
				<div class="modal-footer">
					<a class="btn btn-secondary" href="#" role="button" data-bs-dismiss="modal">No</a>
					<!-- Just close modal -->
					<a class="btn btn-danger" href="admin.php" role="button">Yes</a>
					<!-- the url of this confirmation button will change depending on the button clicked -->
				</div>
			</div>
		</div>
	</div>

	<!-- Edit item information modal -->
	<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="editLabel">Edit Item Information</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form action="admin.php" method="POST">
						<p>
							Item Name :
							<input type="text" name="newName">
							<!-- keeps the item name value given and also protects against injection attacks -->
							<?php print $newNameErr; ?> <!-- error message if name is empty from add.php -->
						</p>
						<div class="d-flex flex-columns my-4">
							<label for="newDescArea">Item Description : </label>

							<textarea id="newDescArea" rows="5" cols="30" type="text" name="newDesc"></textarea>
							<!-- keeps the item name value given and also protects against injection attacks -->
							<?php print $newDescErr; ?> <!-- error message if description is empty from add.php -->
						</div>

						<p>
							Item Price :
							<input type="text" name="newPrice">
							<!-- keeps the item name value given and also protects against injection attacks -->
							<?php print $newPriceErr; ?> <!-- error message if price is empty from add.php -->
						</p>

						<input type="hidden" name="itemID" value="">
						<input type="submit" name="edit" value="SUBMIT">
					</form>
				</div>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.7.0.min.js"
		integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
	<script>
		// When clicked delete button
		$(document).on('click', '.delete', function () {
			// get the item_id from a data attribute of the button

			let item_id = $(this).attr("item_id");
			let item_name = $(this).attr("item_name");

			$("#confirmationLabel").html("Delete Confirmation");
			$(".confirmation-top").html("Are you sure you want to delete");
			$(".confirmation-item").html(item_name);
			$(".confirmation-bottom").html("from menu item?");
			$("#confirmationModal .modal-footer .btn-danger").attr('href', `./admin.php?action=delete&itemID=${item_id}`);

			$('#confirmationModal').modal('show');

		})

		// When clicked disable button
		$(document).on('click', '.disable', function () {
			// get the item_id from a data attribute of the button

			let item_id = $(this).attr("item_id");
			let item_name = $(this).attr("item_name");

			$("#confirmationLabel").html("Disable Confirmation");
			$(".confirmation-top").html("Are you sure you want to disable");
			$(".confirmation-item").html(item_name);
			$(".confirmation-bottom").html("from menu display?");
			$("#confirmationModal .modal-footer .btn-danger").attr('href', `./admin.php?action=disable&itemID=${item_id}`);

			$('#confirmationModal').modal('show');

		})

		// When clicked enable button
		$(document).on('click', '.enable', function () {

			let item_id = $(this).attr("item_id");
			let item_name = $(this).attr("item_name");

			$("#confirmationLabel").html("Enable Confirmation");
			$(".confirmation-top").html("Are you sure you want to enable");
			$(".confirmation-item").html(item_name);
			$(".confirmation-bottom").html("onto menu display?");
			$("#confirmationModal .modal-footer .btn-danger").attr('href', `./admin.php?action=enable&itemID=${item_id}`);

			$('#confirmationModal').modal('show');
		})

		// When clicked edit button
		$(document).on('click', '.edit', function () {

			let item_id = $(this).attr("item_id");
			let item_name = $(this).attr("item_name");
			let item_desc = $(this).attr("item_desc");
			let item_price = $(this).attr("item_price");

			$("#editModal input[name=itemID]").val(item_id);
			$("#editModal input[name=newName]").val(item_name);
			$("#editModal textarea[name=newDesc]").val(item_desc);
			$("#editModal input[name=newPrice]").val(item_price);

			$("#editModal").modal('show');
		})
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
		crossorigin="anonymous"></script>
</body>

</html>