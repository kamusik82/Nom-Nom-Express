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
            $newSql = "SELECT oi.order_id, oi.quantity, m.item_name, m.item_price, o.total, o.date, o.shipping, o.tax
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
                print   "<a class='btn btn-primary mb-2' data-bs-toggle='collapse' data-bs-target='#collapse$order' href='#collapse$order' role='button' aria-expanded='false' aria-controls='#collapse$order'>
                            Order on $oDate
                        </a>";
                print   "<div class='collapse'  id='collapse$order'>
                            <div class='card mb-3'>
                                <div class='row g-0'>
                                    <div class='col'>
                                        <h5 class='card-title'>Order #$order</h5>
                                    </div>
                                    <div class='col-8 d-flex justify-content-center'>
                                        <table width='100%'>
                                            <tr>
                                                <th align='left' width='50%'><b>Name</b></th>
                                                <th align='left' width='20%'><b>Cost</b></th>
                                                <th align='left' width='20%'><b>Amount</b></th>
                                            </tr>";
                // go through the arrays to fill in the data for each field             
                for ($i = 0; $i < count($nameArray); $i++) {
                    print                   "<tr>
                                                <td align='left'>". $nameArray[$i] ."</td>
                                                <td align='left'>$". $priceArray[$i] ."</td>
                                                <td align='left'>". $quantityArray[$i] ."</td>
                                            </tr>";
                }
                    print           "    </table>
                                    </div>
                                    
                                    <div class='col-md-2'>
                                        <table>
                                            <tr>
                                                <th align='center'>Shipping</th>
                                            </tr>
                                            <tr>
                                                <td align='center'>$$shipping</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class='col'>
                                        <table>
                                            <tr>
                                                <th align='center'>Tax</th>
                                            </tr>
                                            <tr>
                                                <td align='center'>$tax%</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class='col'>
                                        <table>
                                            <tr>
                                                <th align='center'>Total</th>
                                            </tr>
                                            <tr>
                                                <td align='center'>$$total</td>
                                            </tr>
                                        </table>
                                    </div>
                                    
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