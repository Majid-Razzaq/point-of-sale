<?php include('includes/header.php'); ?>

    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-4">Customers
                    <a href="customer-create.php" class="btn btn-primary float-end">Add Customer</a>
                </h4>
            </div>
            <div class="card-body">
            <!-- Message function -->
            <?php alertMessage(); ?>
            <!-- Message function -->
            <?php
                $customers = getAll('customers');
                if(!$customers){
                    echo "<h4>Something went wrong!</h4>";
                    return false;
                }
                if($customers && mysqli_num_rows($customers) > 0) {
                 
                ?>
                
                <div class="table-responive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   while ($customer = mysqli_fetch_assoc($customers)) {?>
                                <tr>
                                    <td><?= $customer['id']; ?></td>
                                    <td><?= $customer['name']; ?></td>
                                    <td><?= $customer['email']; ?></td>
                                    <td><?= $customer['phone']; ?></td>
                                    <td>
                                        <?php
                                            if($customer['status'] == 1){
                                                echo '<span class="badge bg-danger">Hidden</span>';
                                            }else{
                                                echo '<span class="badge bg-success">Visible</span>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="customer-edit.php?id=<?= $customer['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="#" onclick="deleteCustomer(<?= $customer['id'] ?>);" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php  } ?>
                            </tbody>
                    </table>
                </div>
                <?php
                           
                        } else {
                            echo "
                                <tr>
                                    <h4 class='mb-0'>No Record found</h4>
                                </tr>
                            ";
                        }
                        ?>
            </div>
        </div>
    </div>

<?php include('includes/footer.php'); ?>

<script>
    function deleteCustomer(customerId) {
        if (confirm("Are you sure you want to delete this Customer")) {
            window.location.href = "customer-delete.php?id=" + customerId;
        }
    }
</script>