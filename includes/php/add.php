<?php

// set up variables
$nameErr = $descErr = $priceErr = $catErr = $fileErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // only validate if the add submit is clicked
    if(isset($_POST['add'])){

        // check if item name is empty
        if (empty($_POST['name'])) {
            $nameErr = '*Please enter an Item Name';
        } else {
            $nameErr = '';
        }

        //check if description is empty
        if(empty($_POST['description'])){
            $descErr = '*Please enter a description';
        } else {
            $descErr = '';
        }

        // check if the price is empty or in the incorrect format
        // when there is more time add replace number strings with appropriate dollar strings
        if (empty($_POST['price'])) {
            $priceErr = '*Please enter a price';
        } else if (!preg_match('/^[0-9]*.[0-9][0-9]$/', $_POST['price'])){
            $priceErr = 'Please enter a value in the format **.**';
        } else {
            $priceErr = '';
        }

        // check if the category drop down has chosen a category
        if(empty($_POST['category'])){
            $catErr = '*Please enter a category';
        } else {
            $catErr = '';
        }

        /* 
            issues with checking if file is uploaded or an image here so using the
            given upload error data from the exercises. Will try to figure out by friday
            but just commented out for now
        */
        // if(empty($_FILES['pic'])){
        //     $fileErr = 'No file was uploaded';
        // } else {
        //     $fileErr = '';
        // }
    }


    if(isset($_FILES['pic']) && !empty($_POST['category']) && !empty($_POST['price']) && !empty($_POST['description']) && !empty($_POST['name'])){
        if (move_uploaded_file ($_FILES['pic']['tmp_name'], ".\\includes\\images\\{$_FILES['pic']['name']}")) {  // save to relevant location

            $name = mysqli_real_escape_string($dbc, $_POST['name']);
            $description = mysqli_real_escape_string($dbc, $_POST['description']);
            $category = mysqli_real_escape_string($dbc, $_POST['category']);
            $price = mysqli_real_escape_string($dbc, $_POST['price']);
            $pic = mysqli_real_escape_string($dbc, "{$_FILES['pic']['name']}");    // pull from relevant location


            $sql = "insert into menu_items (item_name, item_desc, cat_id, item_price, item_picture) values ('$name', '$description', '$category', '$price', '$pic')";
            mysqli_query($dbc,$sql);

            print '<p>Your file has been uploaded.</p>'; // upload statement last to make sure it was actually added to the database

        } else { // Problem!
            print '<p style="color: red;">Your file could not be uploaded because: ';
            
           // Print a message based upon the error:
            switch ($_FILES['pic']['error']) {
                case 1:
                    print 'The file exceeds the upload_max_filesize setting in php.ini';
                    break;
                case 2:
                    print 'The file exceeds the MAX_FILE_SIZE setting in the HTML form';
                    break;
                case 3:
                    print 'The file was only partially uploaded';
                    break;
                case 4:
                    print 'No file was uploaded';
                    break;
                case 6:
                    print 'The temporary folder does not exist.';
                    break;
                default:
                    print 'Something unforeseen happened.';
                    break;
            } 
            
            print '.</p>'; // Complete the paragraph.
        } // End of move_uploaded_file() IF.
    }
    
}

?>