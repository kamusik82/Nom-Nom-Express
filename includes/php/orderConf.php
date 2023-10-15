<?php # This file creates the order confirmation information stored in each order

# TODO: Include connection.php. This will be removed later
include('connection.php');

# TODO: Put dummy order_id which is necessary for retaining order information detail in for now 
$order_id = 3;

# Build and Run the query
$query = "SELECT order_id, first_name, last_name, email, total, date, shipping, tax, item_name, item_price, quantity, item_picture
          FROM orders INNER JOIN order_items USING (order_id) 
                      INNER JOIN menu_items USING (item_id)
                      INNER JOIN users USING (user_id)
          WHERE order_id = $order_id;";
$result = @mysqli_query($dbc, $query);

if ($result) {
    // Initiate variables 
    $first_name = $last_name = $email = $total = $date = $shipping = $tax;

    // create arrays for each column in the query
    $priceArray = array();
    $nameArray = array();
    $quantityArray = array();
    $pictureArray = array();

    $rowCount = 0;

    while ($itemRow = @mysqli_fetch_array($result)) {

        if ($rowCount == 0) { // Assign values just once
            $first_name = $itemRow['first_name'];
            $last_name = $itemRow['last_name'];
            $email = $itemRow['email'];
            $total = $itemRow['total'];
            $date = $itemRow['date'];
            $shipping = $itemRow['shipping'];
            $tax = $itemRow['tax'];
        }

        array_push($priceArray, $itemRow['item_price']);
        array_push($nameArray, $itemRow['item_name']);
        array_push($quantityArray, $itemRow['quantity']);
        array_push($pictureArray, $itemRow['item_picture']);

        $rowCount++;
    }

    # Order Confirmation File
    ob_start(); ?>

    <!-- Actual html content here -->
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <title>Order Confirmation</title>
    </head>
    <style>
        body {
            max-width: 800px;
        }

        .item-pic {
            max-width: 220px;
            width: 100%;
            aspect-ratio: 1/1; 
            object-fit: cover;
        }
    </style>

    <body class="m-5">
        <h2>Order Confirmation</h2>
        <p>Hi <span class="fw-bold"></span><?php echo "$first_name $last_name" ?></span></p>
        <p>Thank you for shopping at Nom Nom Express.<br>
            Your order id No.<?php echo $order_id ?> is confirmed. <br>
            We'll let you know when your order ships.
        </p>
        
        <h3>Order details</h3>
        <p class="text-secondary">Placed on
            <?php echo $date ?>
        </p>
        <div class="border-top border-bottom my-3">
            <table class="table table-borderless">
                <tbody>
                    <?php 

                        for ($i = 0; $i < count($nameArray); $i++) {
                            print   "<tr>
                                        <td align='left'><img src='../images/$pictureArray[$i]' class='item-pic'></td>
                                        <td align='left' class='align-middle'>
                                            <div >
                                                <h5 class='my-3'>$nameArray[$i]</h5>
                                                <p class='fw-bold'>$$priceArray[$i] <span class='text-secondary'>x $quantityArray[$i]</span></p>
                                            </div>
                                        </td>
                                    </tr>";
                        }

                    ?>
                </tbody>
            </table>
        </div>
        <div class="border-bottom">
            <table class="table table-borderless">
                <tbody class="me-3">
                    <tr>
                        <td class="text-secondary">Order ID</td>
                        <td class="text-secondary" align="right">No.<?php echo $order_id ?></td>
                    </tr>
                    <tr>
                        <td class="text-secondary" >Tax</td>
                        <td class="text-secondary" align="right">$<?php echo $tax ?></td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Shipping</td>
                        <td class="text-secondary" align="right">$<?php echo $shipping ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Total</td>
                        <td class="fw-bold" align="right">$<?php echo $total ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
            crossorigin="anonymous"></script>
    </body>

    </html>
    <!-- html end -->

    <?php $orderConf = ob_get_clean(); # HTML is stored in orderConf variable
        $fileName = "O$order_id.php";

        // echo $orderConf;

        # Change directory
        chdir('../orders');

    # Create order confirmation file - Be sure to have permission or chmod
    file_put_contents($fileName, $orderConf, FILE_APPEND | LOCK_EX);
}

?>