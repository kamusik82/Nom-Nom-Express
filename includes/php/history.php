<?php

    $sql = "SELECT distinct oi.order_id, tax, shipping, total, date from order_items oi inner join orders o using (order_id) where user_id = $u_id order by date desc;";
    $oResult = @mysqli_query($dbc, $sql);
    if(mysqli_num_rows($oResult) > 0){
        // go through each individual order
        while($row = @mysqli_fetch_array($oResult)){
            $order = $row['order_id'];
            $tax = $row['tax'];
            $shipping = $row['shipping'];
            $total = $row['total'];
            $oDate = $row['date'];

            // find all the items and info for the individual order
            $newSql = "SELECT oi.order_id, oi.quantity, m.item_name, m.item_price, o.total, FORMAT(o.date, 'dd-MM-yy'), o.shipping, o.tax
                    from orders o inner join order_items oi using (order_id) inner join menu_items m using (item_id)
                    where order_id='$order'
                    order by o.date desc";
            $newResult = @mysqli_query($dbc, $newSql);
            if($newResult){
                // create arrays for each column in the query
                $priceArray = array();
                $nameArray = array();
                $quantityArray = array();

                while($itemRow = @mysqli_fetch_array($newResult)){
                    array_push($priceArray, $itemRow['item_price']);
                    array_push($nameArray, $itemRow['item_name']);
                    array_push($quantityArray, $itemRow['quantity']);
                }

                // each order is placed into a collapse 
                print   "<a class='btn btn-primary my-2' data-bs-toggle='collapse' data-bs-target='#collapse$order' href='#collapse$order' role='button' aria-expanded='false' aria-controls='collapse$order'>
                            Order #$order on $oDate &emsp;Tax: $$tax &emsp;Delivery: $$shipping &emsp;Total: $$total
                        </a>";
                print   "<div class='collapse'  id='collapse$order'>
                            <div class='card mb-3'>
                                <div class='row g-0'>
                                    <table class='col-12'>
                                        <tr>
                                            <th class='col-8 text-start'>Name</th>
                                            <th class='col-2 text-start'>Price</th>
                                            <th class='col-2 text-center'>Amount</th>
                                        </tr>";
                // go through the arrays to fill in the data for each field             
                for ($i = 0; $i < count($nameArray); $i++) {
                    print               "<tr>
                                            <td class='text-start'>". $nameArray[$i] ."</td>
                                            <td class='text-start'>$". $priceArray[$i] ."</td>
                                            <td class='text-center'>". $quantityArray[$i] ."</td>
                                        </tr>";
            }
                    print      "    </table>                                 
                                </div>
                            </div>
                        </div>";
            }
        }
        // if there are no orders yet 
    } else {
        print "<h3>No Orders Yet</h3>";
    } 
?>