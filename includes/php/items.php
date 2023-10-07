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


    $sql = "select item_id, item_name, item_picture, item_desc, disable_item from menu_items order by item_id asc"; 
    $result = mysqli_query($dbc,$sql);

    echo "<style>";
	echo "table, th, td {";
	echo "border: 1px solid black;";
	echo "}";
    echo ".item_picture {";
    echo "width: 100%; height:100%; object-fit: contain;";
    echo "}";
	echo "</style>";
    
    echo "<BR>";
	echo '<table  width="100%" cellspacing="3" cellpadding="3" align="center">
	<tr>
		<td align="left" width="5%"><b>ID</b></td>
		<td align="center" width="20%"><b>Picture</b></td>
		<td align="left" width="20%"><b>Name</b></td>
        <td align="left" width="40%"><b>Description</b></td>
		<td align="center" width="5%"><b>Edit</b></td>
		<td align="center" width="5%"><b>Delete</b></td>
        <td align="center" width="5%"><b>E/D</b></td>
	</tr>';
    
    if ($result) {

        while ($row = mysqli_fetch_array ($result)) {
			$isDisabled = $row['disable_item'];

			if ($isDisabled == 'Y') { // When item is disabled, display "Enable" button
				
				echo "<tr>
						<td align=\"center\">{$row['item_id']}</td>
						<td align=\"center\"><img src=\"{$row['item_picture']}\" class='item_picture'></td>
						<td align=\"center\">{$row['item_name']}</td>
						<td align=\"left\">{$row['item_desc']}</td>
						<td align=\"center\"> <a href=\"\" type='button' class='btn btn-info'>Edit</a></td>
						<td align=\"center\"> <button item_id=\"{$row['item_id']}\" item_name=\"{$row['item_name']}\" type='button' class='btn btn-danger delete'>Delete</button></td>
						<td align=\"center\"> <button item_id=\"{$row['item_id']}\" item_name=\"{$row['item_name']}\" type='button' class='btn btn-success enable'>Enable</button></td>
					</tr>";

			} else { // When item is not disabled, display "Disable" button

				echo "<tr>
						<td align=\"center\">{$row['item_id']}</td>
						<td align=\"center\"><img src=\"{$row['item_picture']}\" class='item_picture'></td>
						<td align=\"center\">{$row['item_name']}</td>
						<td align=\"left\">{$row['item_desc']}</td>
						<td align=\"center\"> <a href=\"\" type='button' class='btn btn-info'>Edit</a></td>
						<td align=\"center\"> <button item_id=\"{$row['item_id']}\" item_name=\"{$row['item_name']}\" type='button' class='btn btn-danger delete'>Delete</button></td>
						<td align=\"center\"> <button item_id=\"{$row['item_id']}\" item_name=\"{$row['item_name']}\" type='button' class='btn btn-warning disable'>Disable</button></td>
					</tr>";

			}

        } 

    } else 
	echo '</table>';

?>