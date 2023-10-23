<?php # This file creates the order confirmation information stored in each order

    # Order Confirmation File
    ob_start(); ?>

    <!-- Actual html content here -->
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/style.css">
        <title>Nom Nom Express</title>
    </head>

    <body class="p-3">
        <div class="container-fluid background pt-2 pb-3 rounded">
            <h2 class="py-3">Order Confirmation</h2>
            <p>Hi <span class="fw-bold"><?php echo "$first_name $last_name" ?></span></p>
            <p>Thank you for shopping at Nom Nom Express.<br>
                Your order id No.<?php echo $order_num ?> is confirmed. <br>
                We'll let you know when your order ships.
            </p>
            
            <h3>Order details</h3>
            <p>Placed on
                <?php echo $date ?>
            </p>
            <div class="border-top border-bottom my-3">  
                <?php 

                    for ($i = 0; $i < count($nameArray); $i++) {
                        print   "<div class='row p-2'>
                                    <div class='d-none d-md-block col text-start'><img src='../images/$pictureArray[$i]' class='cart_picture rounded'></div>
                                    <div class='col text-start'>
                                        <div>
                                            <h5 class='my-3 colour'>$nameArray[$i]</h5>
                                            <p class='fw-bold colour'>$$priceArray[$i] <span class='colour'>x $quantityArray[$i]</span></p>
                                        </div>
                                    </div>
                                </div>";
                    }

                ?>
            </div>
            <div class="border-bottom">
                <table class="table table-borderless border-bottom colour">
                    <tbody class="me-3">
                        <tr>
                            <td>Order ID</td>
                            <td class="text-end">No.<?php echo $order_num ?></td>
                        </tr>
                        <tr>
                            <td>Sub-total</td>
                            <td class="text-end">$<?php print number_format(($totalamt-$taxamt-$shipamt), 2)?></td>

                        <tr>
                            <td>Tax</td>
                            <td class="text-end">$<?php echo number_format($taxamt, 2) ?></td>
                        </tr>
                        <tr>
                            <td>Shipping</td>
                            <td class="text-end">$<?php echo number_format($shipamt, 2) ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Total</td>
                            <td class="fw-bold text-end">$<?php echo number_format($totalamt, 2) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
            crossorigin="anonymous"></script>
    </body>

    </html>
    <!-- html end -->

    <?php $orderConf = ob_get_clean(); # HTML is stored in orderConf variable
        $fileName = "O$order_num.php";

        # Change directory
        chdir('../orders');

    # Create order confirmation file - Be sure to have permission or chmod
    file_put_contents($fileName, $orderConf, FILE_APPEND | LOCK_EX);


?>