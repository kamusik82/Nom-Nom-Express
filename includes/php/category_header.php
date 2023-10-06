
<?php

    $all = 'index.php?all=true';
    $breakfast ='index.php?breakfast=true';
    $burger = 'index.php?burger=true';
    $pizza = 'index.php?pizza=true';
    $dessert = 'index.php?dessert=true';
    $beverage = 'index.php?beverage=true';

    if(isset($_SESSION['user_name'])){

        $sessionUser = $_SESSION['user_name'];
        $sql = "SELECT role from users where username ='$sessionUser'; ";
        $result = mysqli_query($dbc,$sql);

        if($result == 'A'){
            print   '<!-- navigation bar to show categories -->
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
                                    <a class="nav-link" href='.$all.'>All</a>
                                    <a class="nav-link" href='.$breakfast.'>Breakfast</a>
                                    <a class="nav-link" href='.$burger.'>Burgers</a>
                                    <a class="nav-link" href='.$pizza.'>Pizza</a>
                                    <a class="nav-link" href='.$dessert.'>Desserts</a>
                                    <a class="nav-link" href='.$beverage.'>Beverages</a>
                                    <a class="nav-link" href="./admin.php">Admin Page</a>
                                    <form action="./includes/php/logout.php" method="post">	<!-- logout button form action takes you to the logout page (will probably update to just take them back to the landing page) -->
                                        <input type="hidden" name="logout" value="true" />
                                        <input class="nav-link" type="submit" value="Logout" /> <!-- logout submit button -->
                                    </form>
                                </div>

                            </div>
                        </div>
                    </nav>';
            } else {
                print   '<!-- navigation bar to show categories -->
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
                                        <a class="nav-link" href='.$all.'>All</a>
                                        <a class="nav-link" href='.$breakfast.'>Breakfast</a>
                                        <a class="nav-link" href='.$burger.'>Burgers</a>
                                        <a class="nav-link" href='.$pizza.'>Pizza</a>
                                        <a class="nav-link" href='.$dessert.'>Desserts</a>
                                        <a class="nav-link" href='.$beverage.'>Beverages</a>
                                        <a class="nav-link" href="./includes/php/history.php">View Order History</a>
                                        <form action="./includes/php/logout.php" method="post">	<!-- logout button form action takes you to the logout page (will probably update to just take them back to the landing page) -->
                                            <input type="hidden" name="logout" value="true" />
                                            <input class="nav-link" type="submit" value="Logout" /> <!-- logout submit button -->
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </nav>';
            }
    } else {
        print   '<!-- navigation bar to show categories -->
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
                                <a class="nav-link" href='.$all.'>All</a>
                                <a class="nav-link" href='.$breakfast.'>Breakfast</a>
                                <a class="nav-link" href='.$burger.'>Burgers</a>
                                <a class="nav-link" href='.$pizza.'>Pizza</a>
                                <a class="nav-link" href='.$dessert.'>Desserts</a>
                                <a class="nav-link" href='.$beverage.'>Beverages</a>
                                <a class="nav-link btn" id="logon" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                            </div>

                        </div>
                    </div>
                </nav>';
    }

    print   '<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title" id="loginModalLabel">Login</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">';
                            
                            include('./includes/php/login.php');

    print               '</div>
                    </div>
                </div>
            </div>';
?>
