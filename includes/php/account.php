<!DOCTYPE html>
<html lang="en">

<head>
	<title>Nom Nom Express</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <!-- user_info.php calls connection for the page and holds variables for user info -->
    <?php include ('./user_info.php'); ?>
    <!-- Button in the top right orner that leads back to the the index -->
    <div class="d-flex justify-content-end mt-3 mb-3">
        <a class="btn btn-primary me-3" href="../../index.php">Back to Menu</a>
    </div>

    <!-- order history buttons dynamically created using history.php -->
    <div class="container-fluid d-flex flex-row">
        <div class="col-7 mt-2 me-3">
            <h1>Order History</h1>
            <div class="d-flex flex-column">
                <?php include('./history.php'); ?>
            </div>
        </div>

        <!-- Account info uses variables from user_info.php -->
        <div id="info" class="col-4 d-flex align-items-center flex-column mt-2 me-5 shadow rounded">
            <h1 class="me-5">Account Info</h1>
            <div>
                <div>
                    <p>Username: <span><?php print $useName; ?></span></p>
                    <p>First Name: <span><?php print $useFirst; ?></span></p>
                    <p>Last Name: <span><?php print $useLast; ?></span></p>
                </div>
                <div>
                    <p>Street Address: <span><?php print $useAdd; ?></span> </p>
                    <p>Street Address 2: <span><?php print $useAdd2; ?></span></p>
                </div>
                <div>
                    <p>City: <span><?php print $useCity; ?></span></p>
                    <p>Province: <span><?php print $useProv; ?></span></p>
                    <p>Postal: <span><?php print $usePost; ?></span></p>
                </div>
                <div>
                    <p>Email: <span><?php print $useEmail; ?></span></p>
                    <p>Phone Number: <span><?php print $usePhone; ?></span></p>
                    <p>Registration Date: <span><?php print $regDate; ?></span> </p>
                </div>
                <p>
                    Privacy Policy: 
                    <?php print $privacy; ?>
                </p>

                    <!-- php for privacy button -->
                    <?php   if($privacy == 'Signed'){
                                print   "<form action='./account.php' method='POST'>
                                            <button type='submit' class='btn btn-secondary' name='out'>Opt Out</button>
                                        </form>";
                            } else {
                                print   "<div>
                                            <button data-bs-target='#privacy' data-bs-toggle='modal' class='btn btn-primary'>Opt In</button>
                                        </div>

                                        <div class='modal fade' id='privacy' aria-hidden='true' aria-labelledby='privacyModalLabel' tabindex='-1'>
                                            <div class='modal-dialog modal-dialog-centered'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <h1 class='modal-title fs-5' id='privacyModalLabel'>General Data Protection Regulation</h1>
                                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                    </div>
                                                    <div class='modal-body'>
                                                    
                                                    <p>
                                                    The Canadian federal government introduced a new privacy protection law called
                                                    the <b>General Data Protection Regulation</b>. This law requires that individuals must give explicit permission
                                                    for their data to be used and give individuals the right to know who is accessing their information and what it
                                                    will be used for. All companies collecting and/or using personal information on Canadian citizens must comply
                                                    with this new law.
                                                    <p>
                                                    </p>
                                                    Nom Nom Express collects the following information for purposes of Account Registration, Order Tracking and Order Delivery:
                                                        <ul>
                                                            <li>Name</li> 
                                                            <li>Email</li> 
                                                            <li>Phone Number</li>
                                                            <li>Street Address including city, province, and postal code</li>
                                                        </ul>
                                                    </p>
                                                    <p>
                                                    To create an account you must agree to Nom Nom Express collecting this information by clicking the \'Accept\' button below.
                                                    You can change your selection to opt out at any time in User Account settings.
                                                    </p>
                                                    </div>
                                                    <div class='modal-footer'>
                                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Decline</button>
                                                        <form action='./account.php' method='POST'>
                                                            <button type='submit' class='btn btn-primary' name='in'>Accept</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>";
                            }
                    ?>
                </p>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
		crossorigin="anonymous"></script>
</body>
</html>