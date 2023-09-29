<?php
    $sql = "select item_picture, item_desc from menu_items"; 
    $result = mysqli_query($dbc,$sql);

    if ($result)   {
        while ($row = mysqli_fetch_array($result)) {
            print  "<img src=" . $row['item_picture'] . " alt=". $row['item_desc'] .">";	// when needed to style we can add ids or classes to images here
        }
    }

?>