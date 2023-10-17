<!-- This code runs updates the database with the order info, removes the items from the cart, and displays a thank you page for the customer -->
<!-- Need to update with what details we want to display on this page -->

<!DOCTYPE html>
<html>
    <head>
        <title>Order Complete</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="../css/style.css" rel="stylesheet" >
    </head>
    </head>
    <body>
        <h2>Order Complete</h2>
        <div class="d-flex justify-content-end">
            <a class="btn btn-primary me-3" href="../../index.php">Back to menu</a>
        </div>
        <div>
            
            <?php
                require('connection.php');

                // insert order entry in orders table
                $sql_order = "INSERT INTO orders (user_id, tax, shipping, total, date) VALUES ($u_id, $taxamt, $shipamt, $totalamt, now());";
                $result_order = @mysqli_query($dbc, $sql_order);

                // get the order number just created upon insert into orders table
                $sql_order_num = "SELECT max(order_id) FROM orders;";
                $result_order_num = @mysqli_query($dbc, $sql_order_num);
                $row_order_num = mysqli_fetch_assoc($result_order_num);
                $order_num = $row_order_num['max(order_id)'];

                // get rows from cart_items
                $sql_cart = "SELECT cart_items.item_id, quantity, item_price, item_name FROM cart_items INNER JOIN menu_items USING (item_id) WHERE user_id = $u_id;";
                $result_cart = @mysqli_query($dbc, $sql_cart);
                $num_cart = mysqli_num_rows($result_cart);

                // Initialize arrays to store item info for confirmation message
                $priceArray = array();
                $nameArray = array();
                $quantityArray = array();

                // for each cart item, insert into order_items table and delete from cart_items table
                while ($row_cart = mysqli_fetch_array($result_cart, MYSQLI_ASSOC)) {
                    $item = $row_cart['item_id'];
                    $itemName = $row_cart['item_name'];
                    $price = $row_cart['item_price'];
                    $quant = $row_cart['quantity'];

                    // gather item info for confirmation message               
                    array_push($priceArray, $price);
                    array_push($nameArray, $itemName);
                    array_push($quantityArray, $quant);

                    // Insert into order_items table
                    $sql_items = "INSERT INTO order_items (order_id, item_id, cost, quantity) VALUES ($order_num, $item, $price, $quant);";
                    $result_items = @mysqli_query($dbc, $sql_items);

                    // delete from cart_items table
                    $sql_delete_cart = "DELETE FROM cart_items WHERE user_id = $u_id AND item_id = $item;";
                    $result_delete_cart = @mysqli_query($dbc, $sql_delete_cart);
                }
                
                // get users name to use in thank you message
                $sql_user = "SELECT first_name FROM users WHERE user_id=$u_id;";
                $result_user = @mysqli_query($dbc, $sql_user);
                $row_user = mysqli_fetch_assoc($result_user);
                $user = $row_user['first_name'];
            ?>

        </div>
        <div class="container">
            <div class="row mb-3">
                <h5>Thank you for your Nom Nom Express order <span class="fw-bold"><?php print $user?></span>!</h5>
                <br>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <div class="card-title">Order #<?php echo $order_num ?></div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-8 d-flex justify-content-center">
                    <table width="100%" class="border-bottom border-primary">
                        <tr class="border-bottom border-primary">
                            <th class="fw-bold" align="left" width="50%">Item</th>
                            <th class="fw-bold" align="left" width="20%">Price per Item</th>
                            <th class="fw-bold" align="left" width="20%">Quantity</th>
                        </tr>

                        <?php
                            for ($i = 0; $i < count($nameArray); $i++) {
                                print
                                    '<tr>
                                        <td align="left">' . $nameArray[$i] . '</td>
                                        <td align="left">' . $priceArray[$i] . '</td>
                                        <td align="left">' . $quantityArray[$i] . '</td>
                                    </tr>';
                            }
                        ?>

                    </table>
                    <br>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col d-flex flex-column">
                    <div style="font-size: 0.75rem">Sub-total: $<?php print number_format(($totalamt-$taxamt-$shipamt), 2)?></div>
                    <div style="font-size: 0.75rem">Shipping: $<?php print number_format($shipamt, 2)?></div>
                    <div style="font-size: 0.75rem">Taxes: $<?php print number_format($taxamt, 2)?></div>
                    <div class="">Order Total: $<?php print number_format($totalamt, 2)?></div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="fw-bold">We hope you enjoy your meal!</div>
                </div>
            </div>
        </div>
    </body>
</html>






  
  


