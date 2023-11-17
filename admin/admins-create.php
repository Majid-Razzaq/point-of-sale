<?php include('includes/header.php'); ?>

    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-4">Add Admin
                    <a href="admins.php" class="btn btn-primary float-end">Back</a>
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

                    <div class="col-md-6 mb-3">
                        <label for="">Email *</label>
                        <input type="email" name="email" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">password *</label>
                        <input type="password" name="password" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">Phone Number *</label>
                        <input type="number" name="phone" required class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="">Is Ban</label>
                        <br>
                        <input type="checkbox" name="is_ban" style="width: 30px;height: 30px;">
                    </div>
                    <div class="col-md-12 mb-3 text-end">
                        <button type="submit" name="saveAdmin" class="btn btn-primary">Save</button>
                    </div>

                </div>

                </form>
            </div>
        </div>
    </div>

<?php include('includes/footer.php'); ?>