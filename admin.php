<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title> Nom Nom Express Admin Page </title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<link href="./includes/css/style.css" rel="stylesheet">
</head>

<body>

	<?php include("./includes/php/connection.php"); ?> <!-- include for connection php to connect to the database -->

	<div class="d-flex flex-row justify-content-end mt-3 mb-3">
		<form action='./includes/php/logout.php' method='post'>
			<!-- logout button form action takes you to the logout page (will probably update to just take them back to the landing page) -->
			<input type='hidden' name='logout' value='true'>
			<button class="btn btn-primary" type='submit' value='Logout'>Log out</button> <!-- logout submit button -->
		</form>

		<a id="index" href="./index.php" class="btn btn-primary mx-2">Index</a>
	</div>

	<?php include("./includes/php/store_info.php"); ?> <!-- include for the store_info -->

	<div class="container-fluid">
		<div class="row justify-content-center">
			<div id="str_info" class="background col-10 col-md-5 my-1 py-1">
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
			</div>

			<div class="col-0 col-md-1"></div>

			<div id="add" class="background col-10 col-md-5 my-1 py-1">
				<h1 class="ms-5">Add Menu Items Form</h1>

				<?php include("./includes/php/add.php"); ?>
				<!-- include add that validates given form data and updates the database -->

				<form id="addItem" enctype="multipart/form-data" action="admin.php" method="POST">
					<!-- form action is the admin page to stay on the same page -->

					<div class="input-group w-75 ms-5">
						<span class="input-group-text" id="addItem-addon1">Item Name</span>
						<input type="text" class="form-control" aria-label="ItemName" aria-describedby="addItem-addon1"
							name="name" value="<?php if (isset($_POST['name'])) { // keeps the item name value given and also protects against injection attacks
									print htmlspecialchars($_POST['name']);
								} ?>">
					</div>
					<p class="ms-5">
						<?php print $nameErr ?>
					</p> <!-- error message if name is empty from add.php -->

					<div class="input-group w-75 ms-5">
						<span class="input-group-text" id="addItem-addon2">Item Description</span>
						<input type="text" class="form-control" aria-label="ItemDesc" aria-describedby="addItem-addon2"
							name="description" value="<?php if (isset($_POST['description'])) { // keeps the description value given and also protects against injection attacks
									print htmlspecialchars($_POST['description']);
								} ?>">
					</div>
					<p class="ms-5">
						<?php print $descErr ?>
					</p> <!-- error message if description is empty from add.php -->

					<div class="input-group w-75 ms-5">
						<span class="input-group-text" id="addItem-addon3">Item Price $</span>
						<input type="text" class="form-control" aria-label="ItemPrice" aria-describedby="addItem-addon3"
							name="price" value="<?php if (isset($_POST['price'])) { // keeps the price value given and also protects against injection attacks
									print htmlspecialchars($_POST['price']);
								} ?>">
					</div>
					<p class="ms-5">
						<?php print $priceErr ?>
					</p> <!-- error message if price is empty or not a price from add.php -->

					<select class="form-select w-75 ms-5" name="category"> <!-- select drop down for categories -->
						<option value="" selected>Item Category</option>
						<option value="1">Breakfast</option>
						<option value="2">Burgers</option>
						<option value="3">Pizza</option>
						<option value="4">Dessert</option>
						<option value="5">Beverage</option>
					</select>
					<p class="ms-5">
						<?php print $catErr ?>
					</p> <!-- error message if category is not selected from add.php -->

					<div class="w-75 ms-5">
						<label for="formFile" class="form-label">Item Picture</label>
						<input type="hidden" name="MAX_FILE_SIZE" value="300000">
						<input class="form-control" name="pic" type="file" id="formFile">
					</div>
					<p class="ms-5">
						<?php print $fileErr ?>
					</p> <!-- add a file to the form -->

					<button type="submit" name="add" class="btn btn-primary ms-5">Submit</button>
					<!-- add submit button -->
				</form>
			</div>
		</div>
	</div>

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
						<input type="submit" name="update" value="Submit"> <!-- update submit button -->
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid background mt-5 col-11" id="items_table">
		<h1 class="pt-2 px-4 my-3">Current Menu Items</h1>

		<?php include("./includes/php/items.php"); ?> <!-- display current items with php include -->
		<?php include("./includes/php/edit.php"); ?> <!-- edit current items with php include -->
	</div>

	<!-- Confirmation Modal for delete, disable, enable-->
	<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="confirmationLabel">-</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body d-flex flex-column">
					<h6 class="confirmation-top text-center "></h6>
					<h6 class="fs-4 confirmation-item text-center text-decoration-underline"></h6>
					<h6 class="text-center  confirmation-bottom"></h6>
				</div>
				<div class="modal-footer">
					<a class="btn btn-secondary" href="#" role="button" data-bs-dismiss="modal">No</a>
					<!-- Just close modal -->
					<a class="btn btn-primary" href="admin.php" role="button">Yes</a>
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
						<div class="input-group">
							<span class="input-group-text" id="edit-addon1">Item Name :</span>
							<input type="text" class="form-control m-border" aria-label="ItemName"
								aria-describedby="edit-addon1" name="newName">
							<!-- keeps the item name value given and also protects against injection attacks -->
							<p>
								<?php print $newNameErr; ?>
							</p> <!-- error message if name is empty from add.php -->
						</div>

						<div class="input-group my-4">
							<span class="input-group-text">Item Description :</span>
							<textarea id="newDescArea" class="form-control" aria-label="With textarea" rows="5"
								cols="30" name="newDesc"></textarea>
							<!-- keeps the item name value given and also protects against injection attacks -->
							<?php print $newDescErr; ?> <!-- error message if description is empty from add.php -->
						</div>

						<div class="input-group mb-5">
							<span class="input-group-text" id="edit-addon2">Item Price :</span>
							<input type="text" class="form-control m-border" aria-label="ItemPrice"
								aria-describedby="edit-addon2" name="newPrice">
							<!-- keeps the item name value given and also protects against injection attacks -->
							<p>
								<?php print $newPriceErr; ?>
							</p> <!-- error message if name is empty from add.php -->
						</div>

						<input type="hidden" name="itemID" value="">
						<button type="submit" name="edit" class="btn btn-primary">Submit</button>
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

			// item_id needs to be split from id attribute before it is useable
			let split = $(this).attr('id').split("_");
			let item_id = split[0];
			let item_name = $(this).attr("name");

			$("#confirmationLabel").html("Delete Confirmation");
			$(".confirmation-top").html("Are you sure you want to delete");
			$(".confirmation-item").html(item_name);
			$(".confirmation-bottom").html("from menu item?");
			//uses href attribute to delete item
			$("#confirmationModal .modal-footer .btn-primary").attr('href', `./admin.php?action=delete&itemID=${item_id}`);

			$('#confirmationModal').modal('show');

		})

		// When clicked disable button
		$(document).on('click', '.disable', function () {
			// get the item_id from a data attribute of the button

			// item_id needs to be split from id attribute before it is useable
			let split = $(this).attr('id').split("_");
			let item_id = split[0];
			let item_name = $(this).attr("name");

			$("#confirmationLabel").html("Disable Confirmation");
			$(".confirmation-top").html("Are you sure you want to disable");
			$(".confirmation-item").html(item_name);
			$(".confirmation-bottom").html("from menu display?");
			//uses href attribute to disable item
			$("#confirmationModal .modal-footer .btn-primary").attr('href', `./admin.php?action=disable&itemID=${item_id}`);

			$('#confirmationModal').modal('show');

		})

		// When clicked enable button
		$(document).on('click', '.enable', function () {

			// item_id needs to be split from id attribute before it is useable
			let split = $(this).attr('id').split("_");
			let item_id = split[0];
			let item_name = $(this).attr("name");

			$("#confirmationLabel").html("Enable Confirmation");
			$(".confirmation-top").html("Are you sure you want to enable");
			$(".confirmation-item").html(item_name);
			$(".confirmation-bottom").html("onto menu display?");
			//uses href attribute to enable item
			$("#confirmationModal .modal-footer .btn-primary").attr('href', `./admin.php?action=enable&itemID=${item_id}`);

			$('#confirmationModal').modal('show');
		})

		// When clicked edit button
		$(document).on('click', '.edit', function () {

			// item_id needs to be split from id attribute before it is useable
			let split = $(this).attr('id').split("_");
			let item_id = split[0];
			let item_name = $(this).attr("name");
			let item_val = $(this).attr("value").split("#");
			let item_desc = item_val[0];
			let item_price = item_val[1];

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