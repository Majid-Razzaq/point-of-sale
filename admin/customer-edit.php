<?php include('includes/header.php'); ?>

    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-4">Edit Customer
                    <a href="customers.php" class="btn btn-primary float-end">Back</a>
                </h4>
            </div>
            <div class="card-body">

            <!-- Message function -->
                <?php
                    alertMessage();
                ?>
            <!-- Message function -->
                <form action="code.php" method="post">

                <?php
                    $paramValue = checkParamId('id');
                    if(!is_numeric($paramValue)){
                        echo "<h5>'.$paramValue.'</h5>";
                        return false;
                    }

                    $customer = getById('customers',$paramValue);
                    if($customer){
                        if($customer['status'] == 200)
                        {
                ?>

                <input type="hidden" name="customer_id" value="<?= $customer['data']['id'] ?>">

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">Name *</label>
                        <input type="text" value="<?= $customer['data']['name'] ?>" name="name" required class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="">Email *</label>
                        <input type="text" name="email" value="<?= $customer['data']['email'] ?>" required class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="">Phone *</label>
                        <input type="number" value="<?= $customer['data']['phone'] ?>" name="phone" required class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Status (UnChecked=Visible, Checked=Hidden)</label>
                        <br>
                        <input type="checkbox" <?= $customer['data']['status'] == true ?'checked':'' ?> name="status" style="height: 30px; width: 30px;">
                    </div>
              
                    <div class="col-md-6 mb-3 text-end">
                        <br>
                        <button type="submit" name="updateCustomer" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <?php
                    }else{
                        echo '<h5>'.$customer['message'].'</h5>';
                    }
                    }else{
                        echo '<h5>Something went wrong!</h5>';
                        return false;
                    }
                ?>

                </form>
            </div>
        </div>
    </div>

<?php include('includes/footer.php'); ?>