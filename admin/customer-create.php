<?php include('includes/header.php'); ?>

    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-4">Add Customer
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

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">Name *</label>
                        <input type="text" name="name" required class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="">Email *</label>
                        <input type="text" name="email" required class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="">Phone *</label>
                        <input type="number" name="phone" required class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Status (UnChecked=Visible, Checked=Hidden)</label>
                        <br>
                        <input type="checkbox" name="status" style="height: 30px; width: 30px;">
                    </div>
              
                    <div class="col-md-6 mb-3 text-end">
                        <br>
                        <button type="submit" name="saveCustomer" class="btn btn-primary">Save</button>
                    </div>

                </div>

                </form>
            </div>
        </div>
    </div>

<?php include('includes/footer.php'); ?>