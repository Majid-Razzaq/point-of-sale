<?php include('includes/header.php'); ?>

    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-4">Admin/Staff
                    <a href="admins-create.php" class="btn btn-primary float-end">Add Admin</a>
                </h4>
            </div>
            <div class="card-body">
            <!-- Message function -->
            <?php   alertMessage(); ?>
            <!-- Message function -->
            <?php
                $admins = getAll('admins');
                if(!$admins){
                    echo "<h4>Something went wrong!</h4>";
                    return false;
                }
                if($admins && mysqli_num_rows($admins) > 0) {
                 
                ?>
                
                <div class="table-responive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Is Ban</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   while ($admin = mysqli_fetch_assoc($admins)) {?>
                                <tr>
                                    <td><?php echo $admin['id']; ?></td>
                                    <td><?php echo $admin['name']; ?></td>
                                    <td><?php echo $admin['email']; ?></td>
                                    <td>
                                        <?php
                                            if($admin['is_ban'] == 1){
                                                echo '<span class="badge bg-danger">Banned</span>';
                                            }else{
                                                echo '<span class="badge bg-success">Active</span>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="admin-edit.php?id=<?= $admin['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="#" onclick="deleteAdmin(<?= $admin['id'] ?>);" class="btn btn-danger btn-sm">Delete</a>
                                            
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

    function deleteAdmin(adminId) {
        if (confirm("Are you sure you want to delete Admin")) {
            window.location.href = "admin-delete.php?id=" + adminId;
        }
    }
</script>