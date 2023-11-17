<?php include('includes/header.php'); ?>

    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-4">Add Product
                    <a href="products.php" class="btn btn-primary float-end">Back</a>
                </h4>
            </div>
            <div class="card-body">

            <!-- Message function -->
                <?php
                    alertMessage();
                ?>
            <!-- Message function -->
                <form action="code.php" method="post" enctype="multipart/form-data">

                <div class="row">

                    <div class="col-md-12 mb-3">
                        <label for="" class="pb-2">Select Category *</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            <?php
                                $categories = getAll('categories');
                                if($categories){
                                    if(mysqli_num_rows($categories) > 0){
                                        foreach($categories as $category){
                                            echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
                                        }   
                                    }else{
                                        echo '<option value="">No Categories found!</option>';
                                    }
                                }else{
                                    echo '<option value="">Something went wrong</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="">Product Name *</label>
                        <input type="text" name="name" required class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="">Description </label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">Price *</label>
                        <input type="number" name="price" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">Quantity *</label>
                        <input type="number" name="quantity" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">Select Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    
                    <div class="col-md-6">
                        <label>Status (UnChecked=Visible, Checked=Hidden)</label>
                        <br>
                        <input type="checkbox" name="status" style="height: 30px; width: 30px;">
                    </div>

              
                    <div class="col-md-12 mb-3 text-end">
                        <br>
                        <button type="submit" name="saveProduct" class="btn btn-primary">Save</button>
                    </div>

                </div>

                </form>
            </div>
        </div>
    </div>

<?php include('includes/footer.php'); ?>