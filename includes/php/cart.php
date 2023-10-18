<!DOCTYPE html>
<html>
<head>
    <title>Cart Content</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="../css/style.css" rel="stylesheet" >
</head>
<body>
    <h2>Shopping Cart</h2>
    <div class="d-flex justify-content-end">
        <a class="btn btn-primary me-3" href="../../index.php">Back to menu</a>
    </div>

    <?php
    require('connection.php');
    $u_id = $_SESSION['user_id'];
    $sql = "SELECT cart_items.item_id, item_name, item_picture, quantity, item_price, item_price * quantity AS 'TotalPrice' 
            FROM cart_items
            INNER JOIN menu_items ON cart_items.item_id = menu_items.item_id
            WHERE user_id = $u_id";

    $result = @mysqli_query($dbc, $sql);
    $num = mysqli_num_rows($result);

    if ($num > 0) {
        // Display the cart contents in a table
        echo '<div class="d-flex justify-content-center">
                <table id="cart" class="col-11 mt-1">

            <thead>
                <tr>
                    <th class="text-center col-2">Item Name</th>
                    <th class="text-center col-2">Item Picture</th>
                    <th class="text-center col-2">Quantity</th>
                    <th class="text-center col-1">Price</th>
                    <th class="text-center col-1">Total Price</th>
                    <th class="text-center col-1">Delete item</th>
                </tr>
            </thead>
            <tbody>';
        $totalPrice = 0;
        $tax = 0;
        $delivery = 0;
        $numItems = 0;
        
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $subtotal = $row['quantity'] * $row['item_price'];
            $numItems += $row['quantity'];
            $totalPrice += $subtotal;
            $grandTotal = number_format($subtotal, 2);
           
             
            ob_start();
            echo '<tr>
                <td class="text-center">' . $row['item_name'] . '</td>
                <td class="text-center "><img class="cart_picture" src="../images/' . $row['item_picture'] . '" alt="'.$row['item_name'].'"></td>
                <form method="post">
                <td class="text-center">
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <input type="hidden" name="item_id" value="'.$row['item_id'].'">
                    <button class="btn btn-primary border-0" type="submit" name="action" value="decrease">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                        </svg>
                    </button>
                    <span class="quantity"> &nbsp;' .$row['quantity'] . '&nbsp; </span>
                    <button class="btn btn-primary border-0" type="submit" name="action" value="increase">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                    </button>
                </div>
                </td>
                </form>

                <td class="text-center">$' . $row['item_price'] . '</td>
                <td class="text-center">$' . $grandTotal . '</td>
                <form method="post">
                <td class="text-center">
                <input type="hidden" name="item_id" value="'.$row['item_id'].'" />
                <button type="submit" name="btn-delete" class="btn btn-primary border-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                    </svg>
                </button>
                </td>
                </form>
                </tr>';
        }

        echo '</tbody>
            </table></div>';

        $delivery = $numItems*2.50;
        $tax = ($totalPrice+$delivery)*0.12;
        $owing = $totalPrice + $delivery + $tax;
        $owing_cents = $owing*100;

        $sql_address = "SELECT street_1, street_2, city, province, postal, phone FROM users WHERE user_id=$u_id;";
        $result_address = @mysqli_query($dbc, $sql_address);
        $row_address = mysqli_fetch_assoc($result_address);
        $street1 = $row_address['street_1'];
        $street2 = $row_address['street_2'];
        $city = $row_address['city'];
        $province = $row_address['province'];
        $postal = $row_address['postal'];
        $phone = $row_address['phone'];

        echo '<div id="cart_info" class="container">
                <div class="row">
                    <div class="col d-flex flex-column align-items-start">
                        <div class="fw-bold">Delivery Address:</div>
                        <div>' . $street1 . '</div>
                        <div>' . $street2 . '</div>
                        <div>' . $city . '</div>
                        <div>' . $province . '  ' . $postal . '</div>
                        <div>' . $phone . '</div>
                    </div>
                    <div class="col d-flex flex-column align-items-end">
                        <div>Subtotal: $' . number_format($totalPrice, 2) . '</div>
                        <div>Tax: $' . number_format($tax, 2) . '</div>
                        <div>Delivery Fee: $' . number_format($delivery, 2) . '</div>
                        <div class="fs-5 fw-bold">Order Total: $' . number_format($owing, 2) . '</div>
                    </div>
                </div>
            </div>';
    } else {
        echo '<p>No items in the cart</p>';
    }
    
    // Deleting items by click on delete button

    if (isset($_POST['btn-delete'])) {
        $item_id_to_delete = $_POST['item_id'];
    $sql_delete = "DELETE FROM cart_items WHERE item_id = $item_id_to_delete";
    if (mysqli_query($dbc, $sql_delete)) {
    header("Location: ./cart.php");  
    exit();
}   else {
    echo "Error deleting item: " . mysqli_error($dbc);
    }
    ob_end_flush();
}
 
?>

<?php require_once('../../config.php'); ?>

<!-- Clear cart button & Payment button -->
    <div class="mx-5 my-3">
        <div class="row d-flex justify-content-start">
            <div class="col">
                <form method="post">
                    <input type="hidden" name="clear-cart" value="true">
                    <button type="submit" class="btn btn-primary">
                        Clear 
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                            <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
                        </svg>
                    </button>
                </form>    
            </div>
            <div class="col d-flex justify-content-end">
                <form action="charge.php" method="post">
                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="<?php echo $stripe['publishable_key']; ?>"
                        data-description="<?php echo 'Order Payment'; ?>"
                        data-amount="<?php echo $owing_cents; ?>"
                        data-locale="auto"></script>
                    <input type="hidden" name="totalamt_cents" value="<?php echo $owing_cents; ?>" />
                    <input type="hidden" name="totalamt" value="<?php echo $owing; ?>" />
                    <input type="hidden" name="taxamt" value="<?php echo $tax; ?>" />
                    <input type="hidden" name="shipamt" value="<?php echo $delivery; ?>" />
                    <input type="hidden" name="user" value="<?php echo $u_id; ?>" />
                </form>
            </div>
        </div>
    </div>

<?php 
    if (isset($_POST['clear-cart']) && $_POST['clear-cart'] === 'true') { 
    $sql_clear_cart = "DELETE FROM cart_items WHERE user_id = $u_id";
    if (mysqli_query($dbc, $sql_clear_cart)) {
        header("Location: ./cart.php");
        exit();
    }   else {
        echo "Error deleting item: " . mysqli_error($dbc);
        }
    }
?>
<!-- Adjust a quantity -->
<?php
    if (isset($_POST['action'])) {
        $item_to_adjust = $_POST['item_id'];
        $action = $_POST['action'];
        $sql_fetch_quantity = "SELECT quantity FROM cart_items WHERE user_id = $u_id AND item_id = $item_to_adjust";
        $result = mysqli_query($dbc, $sql_fetch_quantity);
    
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $currentQuantity = $row['quantity'];

        if ($action === 'increase') {
            $newQuantity = $currentQuantity + 1;
        } elseif ($action === 'decrease' && $currentQuantity > 1) {
            $newQuantity = $currentQuantity - 1;
        } else {
            $newQuantity = $currentQuantity;
        }
    }
        $sql_adjust = "UPDATE cart_items SET quantity = $newQuantity WHERE item_id = $item_to_adjust";
    
        if (mysqli_query($dbc, $sql_adjust)) {
            header("Location: ./cart.php");
            exit();
        } else {
            echo "Error updating quantity: " . mysqli_error($dbc);
        }
    }
?>
</body>
</html>
 