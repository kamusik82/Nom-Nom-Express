<!-- This code runs updates the database with the order info, removes the items from the cart, and displays a thank you page for the customer -->

<!DOCTYPE html>
<html lang="eng">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nom Nom Express</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="../css/style.css" rel="stylesheet" >
    </head>
    </head>
    <body>
        <div class="d-flex justify-content-end mt-3 mb-3">
            <a class="btn btn-primary me-3" href="../../index.php">Back to Menu</a>
        </div>

        <?php
            require('connection.php');

            // insert order entry in orders table
            $sql_order = "INSERT INTO orders (user_id, tax, shipping, total, date) VALUES ($u_id, $taxamt, $shipamt, $totalamt, now());";
            $result_order = @mysqli_query($dbc, $sql_order);

            // get the order number just created upon insert into orders table
            $sql_order_num = "SELECT max(order_id), date FROM orders;";
            $result_order_num = @mysqli_query($dbc, $sql_order_num);
            $row_order_num = mysqli_fetch_assoc($result_order_num);
            $date = $row_order_num['date'];
            $order_num = $row_order_num['max(order_id)'];

            // get rows from cart_items
            $sql_cart = "SELECT cart_items.item_id, quantity, item_price, item_picture, item_name FROM cart_items INNER JOIN menu_items USING (item_id) WHERE user_id = $u_id;";
            $result_cart = @mysqli_query($dbc, $sql_cart);
            $num_cart = mysqli_num_rows($result_cart);

            // Initialize arrays to store item info for confirmation message
            $priceArray = array();
            $nameArray = array();
            $quantityArray = array();
            $pictureArray = array();

            // for each cart item, insert into order_items table and delete from cart_items table
            while ($row_cart = mysqli_fetch_array($result_cart, MYSQLI_ASSOC)) {
                $item = $row_cart['item_id'];
                $itemName = $row_cart['item_name'];
                $price = $row_cart['item_price'];
                $quant = $row_cart['quantity'];
                $picture = $row_cart['item_picture'];

                // gather item info for confirmation message               
                array_push($priceArray, $price);
                array_push($nameArray, $itemName);
                array_push($quantityArray, $quant);
                array_push($pictureArray, $picture);

                // Insert into order_items table
                $sql_items = "INSERT INTO order_items (order_id, item_id, cost, quantity) VALUES ($order_num, $item, $price, $quant);";
                $result_items = @mysqli_query($dbc, $sql_items);

                // delete from cart_items table
                $sql_delete_cart = "DELETE FROM cart_items WHERE user_id = $u_id AND item_id = $item;";
                $result_delete_cart = @mysqli_query($dbc, $sql_delete_cart);
            }
            
            // get users name to use in thank you message
            $sql_user = "SELECT first_name, last_name FROM users WHERE user_id=$u_id;";
            $result_user = @mysqli_query($dbc, $sql_user);
            $row_user = mysqli_fetch_assoc($result_user);
            $first_name = $row_user['first_name'];
            $last_name = $row_user['last_name'];

            include('./orderConf.php');
        ?>

        <div class="container background pt-3 pb-3 rounded">
            <h1 class="my-3">Order Complete</h1>
            <div class="row mb-3">
                <h5>Thank you for your Nom Nom Express order <span class="fw-bold"><?php print $first_name?></span>!</h5>
                <br>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <div class="card-title">Order #<?php echo $order_num ?></div>
                </div>
            </div>

            <div class="row border-bottom border-primary">
                <div class="fw-bold text-start col-5 col-md-6">Item</div>
                <div class="fw-bold text-start col-4 col-md-2">Price per Item</div>
                <div class="fw-bold text-start col-3 col-md-2">Quantity</div>
            </div>

            <?php
                for ($i = 0; $i < count($nameArray); $i++) {
                    print
                        '<div class="row border-bottom border-primary py-2">
                            <div class="text-start col-5 col-md-6">' . $nameArray[$i] . '</div>
                            <div class="text-start col-4 col-md-2">$' . $priceArray[$i] . '</div>
                            <div class="text-start col-2 col-md-2">x ' . $quantityArray[$i] . '</div>
                        </div>';
                }
            ?>

            <div class="row my-2">
                <div class="col d-flex flex-column">
                    <div style="font-size: 0.75rem">Sub-total: $<?php print number_format(($totalamt-$taxamt-$shipamt), 2)?></div>
                    <div style="font-size: 0.75rem">Shipping: $<?php print number_format($shipamt, 2)?></div>
                    <div style="font-size: 0.75rem">Taxes: $<?php print number_format($taxamt, 2)?></div>
                    <div class="fw-bold my-1">Order Total: $<?php print number_format($totalamt, 2)?></div>
                </div>
            </div>
            <div class="row">
                <div class="col my-1">
                    <h5>We hope you enjoy your meal!</h5>
                </div>
            </div>
        </div>
    </body>
</html>






  
  


