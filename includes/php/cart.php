<!DOCTYPE html>
<html>
<head>
    <title>Cart Content</title>
</head>
<body>
    <h2>Shopping Cart</h2>
    <style>
        /* Add CSS styles */

        h2 {
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
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
        
    </style>

    <?php
    require('connection.php');
    $sql = "SELECT item_name, item_picture, quantity, item_price, item_price * quantity AS 'TotalPrice' 
    FROM cart_items
    INNER JOIN menu_items ON cart_items.item_id = menu_items.item_id
    WHERE user_id = 2";

    $result = @mysqli_query($dbc, $sql);
    $num = mysqli_num_rows($result);

    if ($num > 0) {
        // Display the cart contents in a table
        echo '<table class="table table-hover" width="40%">
            <thead>
                <tr>
                    <th align="center">Item_name</th>
                    <th align="center">Item_picture</th>
                    <th align="center">Quantity</th>
                    <th align="center">Price</th>
                    <th align="center">Total Price</th>
                </tr>
            </thead>
            <tbody>';
        $totalPrice = 0;
         
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $subtotal = $row['quantity'] * $row['item_price'];
            $totalPrice += $subtotal;
            $grandTotal = number_format($subtotal, 2);
             

            echo '<tr>
                <td align="center">' . $row['item_name'] . '</td>
                <td align="center"><img width="100px" src="' . $row['item_picture'] . '" alt="Food description"></td>
                <td align="center">' . $row['quantity'] . '</td>
                <td align="center">' . $row['item_price'] . '</td>
                <td align="center">' . $grandTotal . '</td>
                </tr>';
        }

        echo '</tbody>
            </table>';

        echo '<p>Your order`s price: $' . number_format($totalPrice, 2) . '</p>';
    } else {
        echo '<p>No items in the cart</p>';
    }
    ?>

</body>
</html>
 