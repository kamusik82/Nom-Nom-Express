<!DOCTYPE html>
<html>
    <head>
        <title>Order Complete</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
        <h2>Order Confirmation</h2>
        <div class="d-flex justify-content-end">
            <a class="btn btn-primary me-3" href="../../index.php">Back to menu</a>
        </div>
        <div>
            
            <?php
                require('connection.php');
                
                echo '<p>Debug text:</p>';
                echo 'user: ' . $u_id . '<br>';
                echo 'total: ' . $totalamt . '<br>';
                echo 'tax: ' . $taxamt . '<br>';
                echo 'delivery: ' . $shipamt . '<br>';

                $sql_order = "INSERT INTO orders (user_id, tax, shipping, total, date) VALUES ($u_id, $taxamt, $shipamt, $totalamt, now());";
                $result_order = @mysqli_query($dbc, $sql_order);

                $sql_order_num = "SELECT max(order_id) FROM orders;";
                $result_order_num = @mysqli_query($dbc, $sql_order_num);
                $row_order_num = mysqli_fetch_assoc($result_order_num);
                $order_num = $row_order_num['max(order_id)'];
                echo 'max order number is ' . $order_num . '<br>';

                $sql_cart = "SELECT cart_items.item_id, quantity, item_price FROM cart_items INNER JOIN menu_items USING (item_id) WHERE user_id = $u_id;";
                $result_cart = @mysqli_query($dbc, $sql_cart);
                $num_cart = mysqli_num_rows($result_cart);

                while ($row_cart = mysqli_fetch_array($result_cart, MYSQLI_ASSOC)) {
                    $item = $row_cart['item_id'];
                    $price = $row_cart['item_price'];
                    $quant = $row_cart['quantity'];

                    $sql_items = "INSERT INTO order_items (order_id, item_id, cost, quantity) VALUES ($order_num, $item, $price, $quant);";
                    $result_items = @mysqli_query($dbc, $sql_items);

                    $sql_delete_cart = "DELETE FROM cart_items WHERE user_id = $u_id AND item_id = $item;";
                    $result_delete_cart = @mysqli_query($dbc, $sql_delete_cart);

                    echo 'order_items & cart_items updated for item_id: ' . $item . '<br>';
                }

                echo 'Updates Complete';
                    
                $sql_user = "SELECT first_name, last_name FROM users WHERE user_id=$u_id;";
                $result_user = @mysqli_query($dbc, $sql_user);
                $row_user = mysqli_fetch_assoc($result_user);
                $user = $row_user['first_name'];
            ?>
        </div>
        <div>
            <br>
            <h5>Thank you for your Nom Nom Express order <?php print $user?>!</h5>
            <p>Details</p>
            <p>Order ID: <?php print $order_num?></p>
            <p>Order Total: $<?php print number_format($totalamt, 2)?></p>
            <p>We hope you enjoy your meal!</p>
        </div>
    </body>
</html>






  
  

