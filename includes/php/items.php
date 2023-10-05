<?php

	//
	// If we confirmed to delete an item
	//
	if (isset($_GET['action']) && $_GET['action'] == 'delete')	{

		$id = mysqli_real_escape_string($dbc, trim(strip_tags($_GET['itemID'])));
		// build query
		$query = "DELETE from menu_item WHERE item_id='$id'";
		$result = mysqli_query($dbc, $query);	
        
		if($result == TRUE) {
			?> <script> alert("Record has been deleted"); </script><?php			
		}else {
			?> <script> alert("Record could not be deleted"); </script><?php
		}
		header('Location:../../admin.php');
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
        <td align="center" width="5%"><b>Disable</b></td>
	</tr>';
    
    if ($result) {

        while ($row = mysqli_fetch_array ($result)) {
            echo "<tr>
                    <td align=\"center\">{$row['item_id']}</td>
                    <td align=\"center\"><img src=\"{$row['item_picture']}\" class='item_picture'></td>
                    <td align=\"center\">{$row['item_name']}</td>
                    <td align=\"left\">{$row['item_desc']}</td>
                    <td align=\"center\"> <a href=\"\" type='button' class='btn btn-info'>Edit</a></td>
                    <td align=\"center\"> <button item_id=\"{$row['item_id']}\" item_name=\"{$row['item_name']}\" type='button' class='btn btn-danger delete'>Delete</button></td>
                    <td align=\"center\"> <button type='button' class='btn btn-warning'>Disable</button></td>
                </tr>";
        } 

    } else 
	echo '</table>';

?>