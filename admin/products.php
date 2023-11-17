<?php include('includes/header.php'); ?>

    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-4">Products
                    <a href="product-create.php" class="btn btn-primary float-end">Add Product</a>
                </h4>
            </div>
            <div class="card-body">
            <!-- Message function -->
            <?php alertMessage(); ?>
            <!-- Message function -->
            <?php
                $products = getAll('products');
                if(!$products){
                    echo "<h4>Something went wrong!</h4>";
                    return false;
                }
                if($products && mysqli_num_rows($products) > 0) {
                 
                ?>
                
                <div class="table-responive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   while ($product = mysqli_fetch_assoc($products)) {?>
                                <tr>
                                    <td><?= $product['id']; ?></td>
                                    <td> <img src="../<?= $product['image']; ?>" style="height: 50px; width: 50px;" alt="Img" /> </td>
                                    <td><?= $product['name']; ?></td>
                                    <td>
                                        <?php
                                            if($product['status'] == 1){
                                                echo '<span class="badge bg-danger">Hidden</span>';
                                            }else{
                                                echo '<span class="badge bg-success">Visible</span>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="product-edit.php?id=<?= $product['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="#" onclick="deleteImage(<?= $product['id'] ?>);" class="btn btn-danger btn-sm">Delete</a>
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
    function deleteImage(productId){
        if (confirm("Are you sure you want to delete this Product")) {
            return window.location.href="product-delete.php?id=" + productId;
        }
    }

</script>