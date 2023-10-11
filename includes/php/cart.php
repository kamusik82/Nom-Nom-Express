<!DOCTYPE html>
<html>
<head>
    <title>Cart Content</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <h2>Shopping Cart</h2>
    <div class="d-flex justify-content-end">
        <a class="btn btn-primary me-3" href="../../index.php">Back to menu</a>
    </div>
    <style>
        /* Add CSS styles */

        h2 {
            text-align: center;
        }

        table {
            width: 60%;
            margin: 10px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }


        tr:hover {
            background-color: #ddd;
        }

        p {
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
        }
        .change-quantity {
        background-color: green;
        color: white;
        border: none;  
        padding: 3px 5px;  
        cursor: pointer;  
        }
        .delete {
        background-color: red;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        text-align: center; 
        display: block;
        }
        .clear {
        background-color: red;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        text-align: center; 
        display: block;   
        }
         
        
    </style>

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
        echo '<div class="d-flex justify-content-center" width="100%"><table class="table table-hover" width="40%">
            <thead>
                <tr>
                    <th align="center">Item_name</th>
                    <th align="center">Item_picture</th>
                    <th align="center">Quantity</th>
                    <th align="center">Price</th>
                    <th align="center">Total Price</th>
                    <th alin="center">Delete item</th>
                </tr>
            </thead>
            <tbody>';
        $totalPrice = 0;
        
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $subtotal = $row['quantity'] * $row['item_price'];
            $totalPrice += $subtotal;
            $grandTotal = number_format($subtotal, 2);
             
            ob_start();
            echo '<tr>
                <td align="center">' . $row['item_name'] . '</td>
                <td align="center"><img width="100px" src="../images/' . $row['item_picture'] . '" alt="Food description"></td>
                <td align="center">
                <button class="change-quantity minus" data-item-name="' . $row['item_name'] . '">-</button>
                <span class="quantity">' . $row['quantity'] . '</span>
                <button class="change-quantity plus" data-item-name="' . $row['item_name'] . '">+</button>
                </td>
                <td align="center">' . $row['item_price'] . '</td>
                <td align="center">' . $grandTotal . '</td>
                <form method="post">
                <td align="center">
                <input type="hidden" name="item_id" value="'.$row['item_id'].'" />
                <input type="submit" name="btn-delete" value="X" class="delete" />
                 </td>
                </form>
                </tr>';
        }

        echo '</tbody>
            </table></div>';

        echo '<p class = "order">Your order`s total price: $' . number_format($totalPrice, 2) . '</p>';
    } else {
        echo '<p>No items in the cart</p>';
    }
    
    
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

    <div class="d-flex justify-content-start ms-5 mt-1">
     <form method="post">
    <input type="hidden" name="clear-cart" value="true">
    <input type="submit" value="Clear Cart" class ="clear">
    </form>    
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

</body>
</html>
 