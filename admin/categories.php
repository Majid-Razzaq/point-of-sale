<?php include('includes/header.php'); ?>

    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-4">Categories
                    <a href="categories-create.php" class="btn btn-primary float-end">Add Category</a>
                </h4>
            </div>
            <div class="card-body">
            <!-- Message function -->
            <?php alertMessage(); ?>
            <!-- Message function -->
            <?php
                $categories = getAll('categories');
                if(!$categories){
                    echo "<h4>Something went wrong!</h4>";
                    return false;
                }
                if($categories && mysqli_num_rows($categories) > 0) {
                 
                ?>
                
                <div class="table-responive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   while ($category = mysqli_fetch_assoc($categories)) {?>
                                <tr>
                                    <td><?php echo $category['id']; ?></td>
                                    <td><?php echo $category['name']; ?></td>
                                    <td>
                                        <?php
                                            if($category['status'] == 1){
                                                echo '<span class="badge bg-danger">Hidden</span>';
                                            }else{
                                                echo '<span class="badge bg-success">Visible</span>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="categories-edit.php?id=<?= $category['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="#" onclick="deleteCategory(<?= $category['id'] ?>);" class="btn btn-danger btn-sm">Delete</a>
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
    function deleteCategory(categoryId){
        if (confirm("Are you sure you want to delete this Category")) {
            return window.location.href="categories-delete.php?id=" + categoryId;
        }
    }
</script>