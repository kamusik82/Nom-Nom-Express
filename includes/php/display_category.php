<?php # display_category.php

// This file filters product by selected category

$selected = 'All'; # default displays all category items

// When selected 'all'
if (isset($_GET['all'])){
    $selected = 'All';
}

// When selected 'breakfast'
if (isset($_GET['breakfast'])){ 
    $selected = 'Breakfast';
}

// When selected 'lunch'
if (isset($_GET['burger'])){
    $selected = 'Burgers';  
}

// When selected 'dinner'
if (isset($_GET['pizza'])){
    $selected = 'Pizza';  
}

// When selected 'dessert'
if (isset($_GET['dessert'])){
    $selected = 'Desserts';  
}

// When selected 'beverage'
if (isset($_GET['beverage'])){
    $selected = 'Beverages';  
}


// Make the query:
if ($selected == 'All') // no filter
{
    $q = "SELECT item_id, item_name, item_desc, item_picture, item_price FROM menu_items;"; 
} else { #// filtered by category
    $q = "SELECT item_id, item_name, item_desc, item_picture, item_price 
          FROM menu_items INNER JOIN categories USING(cat_id)
          WHERE cat_name = '$selected';"; 
} 

$r = @mysqli_query($dbc, $q); // Run the query.
$num = mysqli_num_rows($r); // Count the number of row.

$id_array = array();

if ($num > 0) { // If it ran OK, display the records.

	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

        $id = $row['item_id'];
        $name = $row['item_name'];
        $desc = $row['item_desc'];
        $pic = $row['item_picture'];
        $price = $row['item_price'];
        array_push($id_array, $id);

        // the button is disabled if the user is not logged in
        if(isset($_SESSION['user_name'])){
            $uName = $_SESSION['user_name'];
            $check_sql = "SELECT privacy from users where username = '$uName'";
            $check = @mysqli_query($dbc, $check_sql);

            $check_row = mysqli_fetch_array($check, MYSQLI_ASSOC);
            // Add to cart button works if the user is logged in and privacy statement is signed
            if($check_row['privacy'] == 'Y'){
            echo "<div class='col'>
                    <div class='card product h-100'>
                        <img src='$pic' class='card-img-top product-image' alt='$name'>
                        <div class='card-body'>
                            <h5 class='card-title product-title'>$name</h5>
                            <p class='card-text product-description'>$desc</p>
                            <p class='card-text product-price'>$$price</p>
                            <form action='index.php' method='POST'>
                                <button type='submit' class='btn btn-secondary add-to-cart-btn' name='$id'>Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>";
            // if the user has not signed the privacy statement they cannot click add to cart
            } else {
                echo "<div class='col'>
                    <div class='card product h-100'>
                        <img src='$pic' class='card-img-top product-image' alt='$name'>
                        <div class='card-body'>
                            <h5 class='card-title product-title'>$name</h5>
                            <p class='card-text product-description'>$desc</p>
                            <p class='card-text product-price'>$$price</p>
                            <form action='index.php' method='POST'>
                                <button type='submit' class='btn btn-secondary add-to-cart-btn disabled' name='$id'>Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>";
            }
            // if the user is not logged in the add to cart button is disabled 
        } else {
            echo "<div class='col'>
                    <div class='card product h-100'>
                        <img src='$pic' class='card-img-top product-image' alt='$name'>
                        <div class='card-body'>
                            <h5 class='card-title product-title'>$name</h5>
                            <p class='card-text product-description'>$desc</p>
                            <p class='card-text product-price'>$$price</p>
                            <form action='index.php' method='POST'>
                                <button type='submit' class='btn btn-secondary add-to-cart-btn disabled' name='$id'>Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>";
        }
	}

	mysqli_free_result ($r); // Free up the resources.

} else { // If no records were returned.

	echo '<p class="error">There are currently no available items.</p>';

}

// this is just for debugging
if(isset($_SESSION['user_id'])){
    $test = $_SESSION['user_id'];
    print "<p>$test</p>";
}

?>