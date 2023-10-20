<?php

	//
	// If admin confirmed to delete an item
	//
	if (isset($_GET['action']) && $_GET['action'] == 'delete')	{

		$id = trim($_GET['itemID']);
		
		// build query
		$query = "DELETE FROM menu_items WHERE item_id=$id;";
		// run the query
		$result = @mysqli_query($dbc, $query);

		if($result) {
			echo '<script> alert("Selected item has been deleted"); </script>';
		}else {
			echo '<script> alert("Selected item could not be deleted"); </script>';
		}
	}

	//
	// If admin confirmed to disable an item
	//
	if (isset($_GET['action']) && $_GET['action'] == 'disable')	{

		$id = trim($_GET['itemID']);
		
		// build query
		$query = "UPDATE menu_items SET disable_item = 'Y' WHERE item_id = $id;";
		// run the query
		$result = @mysqli_query($dbc, $query);

		if($result) {
			echo '<script> alert("Selected item has been disabled"); </script>';
		}else {
			echo '<script> alert("Selected item could not be disabled"); </script>';
		}
	}

	//
	// If admin confirmed to enable an item
	//
	if (isset($_GET['action']) && $_GET['action'] == 'enable')	{

		$id = trim($_GET['itemID']);
		
		// build query
		$query = "UPDATE menu_items SET disable_item = 'N' WHERE item_id = $id;";
		// run the query
		$result = @mysqli_query($dbc, $query);

		if($result) {
			echo '<script> alert("Selected item has been enabled"); </script>';
		}else {
			echo '<script> alert("Selected item could not be enabled"); </script>';
		}
	}


    $sql = "select item_id, item_name, item_picture, item_desc, item_price, disable_item from menu_items order by item_id asc"; 
    $result = mysqli_query($dbc,$sql);
    
    echo "<BR>";
	echo '<table class="text-center ms-4 me-4">
	<tr>
		<td class="text-center col"><b>ID</b></td>
		<td class="text-center col"><b>Picture</b></td>
		<td class="text-center col-2"><b>Name</b></td>
        <td class="text-center col-4"><b>Description</b></td>
		<td class="text-center col-2"><b>Price</b></td>
		<td class="text-center col-1"><b>Edit</b></td>
		<td class="text-center col-1"><b>Delete</b></td>
        <td class="text-center col-1"><b>E/D</b></td>
	</tr>';
    
    if ($result) {

        while ($row = mysqli_fetch_array ($result)) {
			$isDisabled = $row['disable_item'];
			$alt = $row['item_name'];

			if ($isDisabled == 'Y') { // When item is disabled, display "Enable" button
				
				echo "<tr>
						<td class=\" text-center\">{$row['item_id']}</td>
						<td class=\" text-center\"><img src=\"./includes/images/{$row['item_picture']}\" class='item_picture rounded' alt='$alt'></td>
						<td class=\" text-center\">{$row['item_name']}</td>
						<td class=\" text-center\">{$row['item_desc']}</td>
						<td class=\" text-center\">${$row['item_price']}</td>
						<td class=\" text-center\"> <button id=\"{$row['item_id']}_edit\" name=\"{$row['item_name']}\" value=\"{$row['item_desc']}, {$row['item_price']}\" type='button' class='btn btn-primary edit'>Edit</button></td>
						<td class=\" text-center\"> <button id=\"{$row['item_id']}_delete\" name=\"{$row['item_name']}\" type='button' class='btn btn-primary delete'>Delete</button></td>
						<td class=\" text-center\"> <button id=\"{$row['item_id']}_enable\" name=\"{$row['item_name']}\" type='button' class='btn btn-primary enable'>Enable</button></td>
					</tr>";

			} else { // When item is not disabled, display "Disable" button

				echo "<tr>
						<td class=\" text-center\">{$row['item_id']}</td>
						<td class=\" text-center\"><img src=\"./includes/images/{$row['item_picture']}\" class='item_picture rounded' alt='$alt'></td>
						<td class=\" text-center\">{$row['item_name']}</td>
						<td class=\" text-start\">{$row['item_desc']}</td>
						<td class=\" text-center\">\${$row['item_price']}</td>
						<td class=\" text-center\"> <button id=\"{$row['item_id']}_edit\" name=\"{$row['item_name']}\" value=\"{$row['item_desc']}#{$row['item_price']}\" type='button' class='btn btn-primary edit'>Edit</button></td>
						<td class=\" text-center\"> <button id=\"{$row['item_id']}_delete\" name=\"{$row['item_name']}\" type='button' class='btn btn-primary delete'>Delete</button></td>
						<td class=\" text-center\"> <button id=\"{$row['item_id']}_disable\" name=\"{$row['item_name']}\" type='button' class='btn btn-primary disable'>Disable</button></td>
					</tr>";

			}

        } 

    } else 
	echo '</table>';

?>