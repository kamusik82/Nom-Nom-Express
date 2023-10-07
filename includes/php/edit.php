<?php // edit item information (basically same as add.php)

// set up variables
$newNameErr = $newDescErr = $newPriceErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // only validate if the add submit is clicked
    if (isset($_POST["edit"])) {

        // check if item name is empty
        if (empty($_POST["newName"])) {
            $newNameErr = "*Please enter an Item Name";
        } else {
            $newNameErr = "";
        }

        //check if description is empty
        if (empty($_POST["newDesc"])) {
            $newDescErr = "*Please enter a description";
        } else {
            $newDescErr = "";
        }

        // check if the price is empty or in the incorrect format
        // when there is more time add replace number strings with appropriate dollar strings
        if (empty($_POST["newPrice"])) {
            $newPriceErr = "*Please enter a price";
        } else if (!preg_match("/^[0-9]*.[0-9][0-9]$/", $_POST["price"])) {
            $newPriceErr = "Please enter a value in the format **.**";
        } else {
            $newPriceErr = "";
        }
    }
}

if (!empty($_POST['newName']) && !empty($_POST['newDesc']) && !empty($_POST['newPrice'])) {
    $item_id = $_POST['itemID'];
    $name = mysqli_real_escape_string($dbc, $_POST['name']);
    $description = mysqli_real_escape_string($dbc, $_POST['description']);
    $price = mysqli_real_escape_string($dbc, $_POST['price']);

    $query = "update menu_items set item_name = '$name', item_desc ='$description', item_price = $price where item_id = $item_id;";
    $result = @mysqli_query($dbc, $query);

    if($result) {
        echo '<script> alert("Selected item information has been updated"); </script>';
    }else {
        echo '<script> alert("Selected item information has been updated); </script>';
    }
}


?>