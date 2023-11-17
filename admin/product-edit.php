<?php include('includes/header.php'); ?>

    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-4">Edit Product
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

                <?php
                    $paramValue = checkParamId('id');
                    if(!is_numeric($paramValue)){
                        echo '<h5>Invalid input!</h5>';
                        return false;
                    }
                    
                    $product = getById('products',$paramValue);
                    if($product){
                        if($product['status'] == 200){
                    ?>
                    <input type="hidden" name="product_id" value="<?= $product['data']['id'] ?>">
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
                                                ?>
                                                <option value="<?= $category['id']; ?>"
                                                <?= $product['data']['category_id'] == $category['id'] ? 'selected':''; ?>
                                                >
                                                    <?= $category['name'] ?>     
                                               </option>
                                                <?php
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
                            <input type="text" name="name" value="<?= $product['data']['name']  ?>" required class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="">Description </label>
                            <textarea name="description" class="form-control" rows="3"><?= $product['data']['description']  ?></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Price *</label>
                            <input type="number" value="<?= $product['data']['price']  ?>" name="price" required class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Quantity *</label>
                            <input type="number" value="<?= $product['data']['quantity']?>" name="quantity" required class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Select Image</label>
                            <input type="file" name="image" class="form-control">
                            <img src="../<?= $product['data']['image']?>" height="40px" width="40px" alt="Img">
                        </div>
                        
                        <div class="col-md-6">
                            <label>Status (UnChecked=Visible, Checked=Hidden)</label>
                            <br>
                            <input type="checkbox" <?= $product['data']['status'] == true ?'checked':''  ?> name="status" style="height: 30px; width: 30px;">
                        </div>

                
                        <div class="col-md-12 mb-3 text-end">
                            <br>
                            <button type="submit" name="updateProduct" class="btn btn-primary">Update</button>
                        </div>

                    </div>

                  <?php 
                    }else{
                        echo '<h5>'.$product['message'].'</h5>';
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