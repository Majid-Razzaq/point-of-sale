<?php

include('../config/function.php');

    // Insert Admin Data
    if(isset($_POST['saveAdmin'])){

        $name = validate($_POST['name']);
        $email = validate($_POST['email']);
        $password = validate($_POST['password']);
        $phone = validate($_POST['phone']);
        $is_ban = isset($_POST['is_ban']) == true ? 1:0;
        
        if($name != '' && $email != '' && $password != ''){

            $emailCheck = mysqli_query($conn,"SELECT * FROM admins WHERE email='$email'");
            if($emailCheck){
                if(mysqli_num_rows($emailCheck) > 0){
                  
                    redirect('admins-create.php','Email already used by another user.');
                }
            }

            $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

            $data = [
                'name' => $name,
                'email' => $email,
                'password' => $bcrypt_password,
                'phone' => $phone,
                'is_ban' => $is_ban,
            ];

            $result = insert('admins',$data);
            if($result){
                redirect('admins.php','Admin created successfully!');

            }else{
                redirect('admins-create.php','Something went wrong!');
            }

        }
        else{
            redirect('admins-create.php','Please fill required fields');
        }
    }


    // Update Admin Data
    if(isset($_POST['updateAdmin'])){
        $adminId = validate($_POST['adminId']);        

        $adminData = getById('admins',$adminId);
        if($adminData['status'] != 200){

            redirect('admin-edit.php?id='.$adminId,'Please fill required fields');

        }   

        $name = validate($_POST['name']);
        $email = validate($_POST['email']);
        $password = validate($_POST['password']);
        $phone = validate($_POST['phone']);
        $is_ban = isset($_POST['is_ban']) == true ? 1:0;

        $emailCheckQuery = "SELECT * FROM admins WHERE email=$email AND id!='$adminId'";
        $checkResult = mysqli_query($conn, $emailCheckQuery);
        if($checkResult){
            if(mysqli_num_rows($checkResult) > 0){
                redirect('admin-edit.php?id='.$adminId,'Email already used by another user');
            }
        }

        if($password != ''){
            $hashedPass = password_hash($password, PASSWORD_BCRYPT);
        }else{
            $hashedPass = $adminData['data']['password'];
        }
        
        if($name != '' && $email != ''){
          
            $data = [
                'name' => $name,
                'email' => $email,
                'password' => $hashedPass,
                'phone' => $phone,
                'is_ban' => $is_ban,
            ];

            $result = update('admins',$adminId, $data);
            if($result){
                redirect('admin-edit.php?id='.$adminId,'Admin updated successfully!');

            }else{
                redirect('admins-edit.php?id='.$adminId,'Something went wrong!');
            }

        }
        else{
            redirect('admin-edit.php','Please fill required fields');
        }
    }

    // Save Category 
    if(isset($_POST['saveCategory'])){

        $name = validate($_POST['name']);
        $description = validate($_POST['description']);
        $status = isset($_POST['status']) == true ? 1:0;

        $data = [
            'name' => $name,
            'description' => $description,
            'status' => $status,
        ];

        $result = insert('categories',$data);
        if($result){
            redirect('categories.php','Category created successfully.');
        }else{
            redirect('categories-create.php','Something went wrong.');
        }

    }

    // Update Category
    if(isset($_POST['updateCategory'])){

        $categoryId = validate($_POST['categoryId']);
        $name = validate($_POST['name']);
        $description = validate($_POST['description']);
        $status = isset($_POST['status']) == true ? 1:0;

        $data = [
            'name' => $name,
            'description' => $description,
            'status' => $status,
        ];

        $result = update('categories', $categoryId,$data);
        if($result)
        {
            redirect('categories-edit.php?id='.$categoryId,'Category Updated successfully.');
        }
        else{
            redirect('categories-edit.php?id='.$categoryId,'Something went wrong.');
        }

    }


// Insert Product Data

    if(isset($_POST['saveProduct']))
    {
        $category_id = validate($_POST['category_id']);
        $name = validate($_POST['name']);
        $description = validate($_POST['description']);
        $price = validate($_POST['price']);
        $quantity = validate($_POST['quantity']);
        $status = isset($_POST['status']) == true ? 1:0;

        // Add Image code 
        if($_FILES['image']['size'] > 0){
            
            $path = "../assets/uploads/products";
            $img_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

            $filename = time().'.'.$img_ext;

            move_uploaded_file($_FILES['image']['tmp_name'], $path."/".$filename);
            $finalImage = "assets/uploads/products/".$filename;

        }else{
            $finalImage = '';
        }

        $data = [
            'category_id' => $category_id,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'quantity' => $quantity,
            'status' => $status, 
            'image' => $finalImage,
        ];

        $result = insert('products',$data);
        if($result){
            redirect('products.php','Product added successfully');
        }else{
            redirect('product-create.php','Something went wrong');
        }

    }

    // update product 
    if(isset($_POST['updateProduct'])){
        $product_id = validate($_POST['product_id']);
        $productData = getById('products',$product_id);
        if(!$productData){
            redirect('products.php','No such porduct found.');
        }

        $category_id = validate($_POST['category_id']);

        $name = validate($_POST['name']);
        $description = validate($_POST['description']);
        $price = validate($_POST['price']);
        $quantity = validate($_POST['quantity']);
        $status = isset($_POST['status']) == true ? 1:0;

        // Add Image code 
        if($_FILES['image']['size'] > 0){
            
            $path = "../assets/uploads/products";
            $img_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

            $filename = time().'.'.$img_ext;

            move_uploaded_file($_FILES['image']['tmp_name'], $path."/".$filename);
            $finalImage = "assets/uploads/products/".$filename;

            $deleteImage = "../".$productData['data']['image'];
            if(file_exists($deleteImage)){
                unlink($deleteImage);
            }

        }else{
            $finalImage = $productData['data']['image'];
        }

        $data = [
            'category_id' => $category_id,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'quantity' => $quantity,
            'status' => $status, 
            'image' => $finalImage,
        ];

        $result = update('products',$product_id,$data);
        if($result){
            redirect('product-edit.php?id='.$product_id,'Product updated successfully');
        }else{
            redirect('product-edit.php?id='.$product_id,'Something went wrong');
        }

    }

    // Save Customer Data
    if(isset($_POST['saveCustomer']))
    {
        $name = validate($_POST['name']);
        $email = validate($_POST['email']);
        $phone = validate($_POST['phone']);
        $status = isset($_POST['status']) == true ? 1:0;

        if($name != null){
            $emalCheck = mysqli_query($conn,"SELECT * FROM customers WHERE email='$email'");
            if($emailCheck){
                if(mysqli_num_rows($emailCheck) > 0){
                    redirect('customers.php','Email already used by another user.');
                }
            }
            $data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'status' => $status,
            ];
            $result = insert('customers',$data);
            if($result){
                redirect('customers.php','Customer created successfully.');
            }
            else{
                redirect('customer-create.php','Something went wrong.');
            }
        }else{
            redirect('customers.php','Please fill required fields.');
        }
      
    }

    // Update Product 
    if(isset($_POST['updateCustomer'])){

        $customer_id = validate($_POST['customer_id']);
        $customerData = getById('customers',$customer_id);
        if(!$customerData){
            redirect('customer-edit.php?id='.$customer_id,'No such customer found.');
        }

        $name = validate($_POST['name']);
        $email = validate($_POST['email']);
        $phone = validate($_POST['phone']);
        $status = validate($_POST['status']) == true ? 1:0;

        if($name != null){
            $emalCheck = mysqli_query($conn,"SELECT * FROM customers WHERE email='$email' AND id!='$customer_id'");
            if($emailCheck){
                if(mysqli_num_rows($emailCheck) > 0){
                    redirect('customer-edit.php?id='.$customer_id,'Email already used by another user.');
                }
            }
            $data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'status' => $status,
            ];
            $result = update('customers',$customer_id,$data);
            if($result){
                redirect('customer-edit.php?id='.$customer_id,'Customer updated successfully.');
            }
            else{
                redirect('customer-edit.php?id='.$customer_id,'Something went wrong.');
            }
        }
        else{
            redirect('customer-edit.php?id='.$customer_id,'Please fill required fields.');
        }
    }

    
?>