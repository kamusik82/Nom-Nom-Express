<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        for($i = 0; $i < count($id_array); $i++){
            $k = $id_array[$i];
            $u_id = $_SESSION['user_id'];
            if(isset($_POST["$k"])){
                $sql = "SELECT item_id,quantity from cart_items where (item_id='$k' and user_id='$u_id');";
                $result = mysqli_query($dbc, $sql);
                $row = mysqli_fetch_array($result);
                if(@is_null($row['item_id'])){
                    $sql = "insert into cart_items(user_id,item_id,quantity) values($u_id,$k, 1);";
                    mysqli_query($dbc, $sql);
                } else {
                    $quantity = $row['quantity'] + 1;
                    $sql = "UPDATE cart_items set quantity='$quantity' where (item_id='$k' and user_id='$u_id');";
                    mysqli_query($dbc, $sql);
                }
            }
        }
    }
?>