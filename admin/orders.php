<?php include('includes/header.php'); ?>

    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">

                <div class="row">
                    <div class="col-md-4">
                        <h4 class="mb-0">Orders</h4>
                    </div>
                    <div class="col-md-8">
                        <form action="" method="get">
                                <div class="row g-1">
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" name="date" value="<?= isset($_GET['date']) == true ? $_GET['date'] : '' ?>" />
                                    </div>

                                    <div class="col-md-4">
                                        <select name="payment_status" class="form-select">
                                            <option value="">Select Payment Status</option>
                                            <option value="Cash Payment" 
                                            <?= isset($_GET['payment_status']) == true ? ($_GET['payment_status'] == 'Cash Payment' ? 'selected':'') : ''; ?>>
                                            Cash Payment
                                            </option>
                                            <option value="Online Payment"
                                            <?= isset($_GET['payment_status']) == true ? ($_GET['payment_status'] == 'Online Payment' ? 'selected' : ''):''; ?>>
                                            Online Payment</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="orders.php" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php 
                    if(isset($_GET['date']) || isset($_GET['payment_status'])){

                        $orderDate = validate($_GET['date']);
                        $paymentStatus = validate($_GET['payment_status']);

                        if($orderDate != '' && $paymentStatus == ''){

                            $query = "SELECT o.*, c.* FROM orders o, customers c
                             WHERE c.id = o.customer_id AND o.order_date='$orderDate' ORDER BY o.id DESC";   

                        }elseif($orderDate == '' && $paymentStatus != ''){

                            $query = "SELECT o.*, c.* FROM orders o, customers c
                             WHERE c.id = o.customer_id AND o.payment_mode='$paymentStatus' ORDER BY o.id DESC";   
                        }
                        elseif($orderDate != '' && $paymentStatus != ''){
                 
                            $query = "SELECT o.*, c.* FROM orders o, customers c
                            WHERE c.id = o.customer_id AND o.order_date='$orderDate'
                            AND o.payment_mode='$paymentStatus' ORDER BY o.id DESC";   
                    
                        }else{
                            
                            $query = "SELECT o.*, c.* FROM orders o, customers c
                            WHERE c.id = o.customer_id ORDER BY o.id DESC";
                        }

                    }else{

                        $query = "SELECT o.*, c.* FROM orders o, customers c
                        WHERE c.id = o.customer_id ORDER BY o.id DESC";   
              
                    }
                  
                    $orders = mysqli_query($conn, $query);
                    if($orders){
                        if(mysqli_num_rows($orders) > 0){
                            ?>

                            <table class="table table-striped table-bordered align-items-center justify-content-center">
                                <thead>
                                    <tr>
                                        <th>Tracking No.</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Order Date</th>
                                        <th>Order Status</th>
                                        <th>Payment Mode</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach($orders as $orderItem): ?>
                                        <tr>
                                            <td class="fw-bold"><?= $orderItem['tracking_no'] ?></td>
                                            <td><?= $orderItem['name'] ?></td>
                                            <td><?= $orderItem['phone'] ?></td>
                                            <td><?= date('d,M,Y',strtotime($orderItem['order_date']))  ?></td>
                                            <td><?= $orderItem['order_status'] ?></td>
                                            <td><?= $orderItem['payment_mode'] ?></td>
                                            <td>
                                                <a href="orders-view.php?track=<?= $orderItem['tracking_no'] ?>" class="btn btn-info mb-0 px-2 btn-sm">View</a>
                                                <a href="orders-view-print.php?track=<?= $orderItem['tracking_no'] ?>" class="btn btn-primary mb-0 px-2 btn-sm">Print</a>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        <?php
                        }else{
                            echo '<h5>No Record Availible</h5>';
                        }
                    }else{

                        echo '<h5>Something went wrong!</h5>';
                    }
                ?>
            </div>
        </div>
    </div>

<?php include('includes/footer.php'); ?>