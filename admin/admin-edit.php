<?php include('includes/header.php'); ?>

    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-4">Edit Admin
                    <a href="admins.php" class="btn btn-danger float-end">Back</a>
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
                    if(isset($_GET['id'])){
                        if($_GET['id'] != ''){
                            $adminId = $_GET['id'];
                    }else{
                        echo'<h5>No Id found!</h5>';
                        return false;
                    }
                }else{

                    echo'<h5>No Id given in params</h5>';
                    return false;
                }

                $adminData = getById('admins',$adminId);
                if($adminData){
                    if($adminData['status'] == 200)
                    {
                        ?>

                    <input type="hidden" name="adminId" value="<?= $adminData['data']['id']?>" />
                    <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">Name *</label>
                        <input type="text" name="name" value="<?= $adminData['data']['name']  ?>" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">Email *</label>
                        <input type="email" name="email" value="<?= $adminData['data']['email']  ?>" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">password *</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">Phone Number *</label>
                        <input type="number" name="phone" value="<?= $adminData['data']['phone']  ?>" required class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="">Is Ban</label>
                        <input type="checkbox" name="is_ban" <?= $adminData['data']['is_ban'] == true ? 'checked' : ''; ?> style="width: 30px;height: 30px;">
                    </div>
                    
                    <div class="col-md-12 mb-3 text-end">
                        <button type="submit" name="updateAdmin" class="btn btn-primary">Update</button>
                    </div>

                </div>

                        <?php
                    }else{
                        echo '<h5>'.$adminData['message'].'</h5>';
                    }
                }
                else{
                    echo 'Something went wrong';
                    return false;
                }
                ?>

           

                </form>
            </div>
        </div>
    </div>

<?php include('includes/footer.php'); ?>