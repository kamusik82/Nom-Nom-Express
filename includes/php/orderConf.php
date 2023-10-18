<?php # This file creates the order confirmation information stored in each order

    # Order Confirmation File
    ob_start(); ?>

    <!-- Actual html content here -->
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="../style.css">
        <title>Order Confirmation</title>
    </head>
    <style>

        body {
            max-width: 800px;
        }
    </style>

    <body class="m-5">
        <h2>Order Confirmation</h2>
        <p>Hi <span class="fw-bold"></span><?php echo "$first_name $last_name" ?></span></p>
        <p>Thank you for shopping at Nom Nom Express.<br>
            Your order id No.<?php echo $order_num ?> is confirmed. <br>
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
                                        <td align='left'><img src='../images/$pictureArray[$i]' class='cart_picture'></td>
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
                        <td class="text-secondary" align="right">No.<?php echo $order_num ?></td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Sub-total</td>
                        <td class="text-secondary" align="right">$<?php print number_format(($totalamt-$taxamt-$shipamt), 2)?></td>
                    </tr>
                    <tr>
                        <td class="text-secondary" >Tax</td>
                        <td class="text-secondary" align="right">$<?php echo number_format($taxamt, 2) ?></td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Shipping</td>
                        <td class="text-secondary" align="right">$<?php echo number_format($shipamt, 2) ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Total</td>
                        <td class="fw-bold" align="right">$<?php echo number_format($totalamt, 2) ?></td>
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
        $fileName = "O$order_num.php";

        // echo $orderConf;

        # Change directory
        chdir('../orders');

    # Create order confirmation file - Be sure to have permission or chmod
    file_put_contents($fileName, $orderConf, FILE_APPEND | LOCK_EX);

?>