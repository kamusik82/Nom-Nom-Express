<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="./includes/css/style.css" rel="stylesheet" >
    <title>Display Category</title>
</head>

<body>
    <?php require('./includes/php/connection.php'); ?>
    <?php include ("./includes/php/category_header.php"); ?>

    <!-- Display Items Here -->
    <div id="products" class="container text-center my-5">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 products g-2 g-lg-3">

            <?php
                include("./includes/php/display_category.php");
            ?>
            <?php include("./includes/php/add_to_cart.php"); ?>       
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
		integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>

        <!-- this script makes it so the modal keeps opening unless the correct information is put in -->
        <?php 
            echo "<script>$(document).ready(function(){";
            if (!isset($_SESSION['user_id'])) {
                echo '$("#loginModal").modal("show");';
            } else {
                echo '$("#loginModal").modal("hide");';
            }
            echo "});</script>";
        ?>
</body>

</html>