<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        for($i = 0; $i < count($id_array)+1; $i++){
            if(isset($_POST["$id_array[$i]"])){
                $sql = "SELECT item_id,quantity from cart_items where item_id='$id_array[$i]';";
                $result = mysqli_query($dbc, $sql);
                if(!$result){
                    $sql = "insert into cart_items(user_id,item_id,quantity) values(1,$id_array[$i], 1);";
                    mysqli_query($dbc, $sql);
                } else {
                    $row = mysqli_fetch_array($result);
                    $quantity = $row['quantity'] + 1;
                    $sql = "UPDATE cart_items set quantity='$quantity' where item_id='$id_array[$i]';";
                }
                print "<p>this part works</p>";
            } else {
                print "<p>no</p>";
            }
        }
    }
?>