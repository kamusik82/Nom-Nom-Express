<?php

    $sql = "select store_name, location, hours, phone, email from store_info"; 
    $result = mysqli_query($dbc,$sql);
    $row = mysqli_fetch_array($result);

    $workingHours = $row['hours'];
	$storeNum = $row['phone'];
	$storeLoc = $row['location'];
	$storeEmail = $row['email'];

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // only change data if update submit is clicked
        if(isset($_POST['update'])){
            
            // only update data for the fields that have been changed
            if (!empty($_POST['hours'])) { 
                $workingHours = $_POST['hours'];
                $sql_update = "update store_info set hours = '$workingHours' where store_id = 1;";
                @mysqli_query($dbc, $sql_update);
            }

            if (!empty($_POST['phone'])) { 
                $storeNum = $_POST['phone'];
                $sql_update = "update store_info set phone = '$storeNum' where store_id = 1;";
                @mysqli_query($dbc, $sql_update);
            }

            if (!empty($_POST['location'])) { 
                $storeLoc = $_POST['location']; 
                $sql_update = "update store_info set location = '$storeLoc' where store_id = 1;";
                @mysqli_query($dbc, $sql_update);
            }

            if (!empty($_POST['email'])) { 
                $storeEmail = $_POST['email'];
                $sql_update = "update store_info set email = '$storeEmail' where store_id = 1;";
                @mysqli_query($dbc, $sql_update);
            }
        } 
    }
?>