<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Display Category</title>
</head>

<body>

    <!-- navigation bar to show categories -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Nom Nom Express</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="mr-5 collapse navbar-collapse" id="navbarNavAltMarkup">

                <!-- categories -->
                <div class="navbar-nav">
                    <a class="nav-link" href='category_header.php?all=true'>All</a>
                    <a class="nav-link" href='category_header.php?breakfast=true'>Breakfast</a>
                    <a class="nav-link" href='category_header.php?burger=true'>Burgers</a>
                    <a class="nav-link" href='category_header.php?pizza=true'>Pizza</a>
                    <a class="nav-link" href='category_header.php?dessert=true'>Desserts</a>
                    <a class="nav-link" href='category_header.php?beverage=true'>Beverages</a>
                </div>

            </div>
        </div>
    </nav>

    <!-- Display Items Here -->
    <div class="container text-center my-5">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 products g-2 g-lg-3">

            <?php
                include("display_category.php");
            ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>