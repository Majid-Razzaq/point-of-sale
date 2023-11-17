<?php

include('../config/function.php');

if(!isset($_SESSION['productItems'])){
    $_SESSION['productItems'] = [];
}

if(!isset($_SESSION['productItemIds'])){
    $_SESSION['productItemIds'] = [];
}

    if(isset($_POST['addItem'])){
        
        $productId = validate($_POST['product_id']);
        $quantity = validate($_POST['quantity']);
     
        $checkProduct = mysqli_query($conn, "SELECT * FROM products where id='$productId' LIMIT 1");
        if($checkProduct){
            if(mysqli_num_rows($checkProduct) > 0){
                $row = mysqli_fetch_assoc($checkProduct);
                if($row['quantity'] < $quantity){
                    redirect('order-create.php','Only '.$row['quantity'].' quantity available!');    
                }  
                
                $productData = [
                    'product_id' => $row['id'],
                    'name' => $row['name'],
                    'image' => $row['image'],
                    'price' => $row['price'],
                    'quantity' => $quantity,
                ];

                if(!in_array($row['id'], $_SESSION['productItemIds'])){
                    array_push($_SESSION['productItemIds'],$row['id']);
                    array_push($_SESSION['productItems'],$productData);
                }else{
                    foreach($_SESSION['productItems'] as $key => $productSessionItem){
                        if($productSessionItem['product_id'] == $row['id']){

                            $newQuantity = $productSessionItem['product_id'] + $quantity;
                            
                            $productData = [
                                'product_id' => $row['id'],
                                'name' => $row['name'],
                                'image' => $row['image'],
                                'price' => $row['price'],
                                'quantity' => $newQuantity,
                            ];
                            $_SESSION['productItems'][$key] = $productData;
                        }
                    }
                }

                redirect('order-create.php','item added '.$row['name']);    


                
            }else{
                redirect('order-create.php','No such product found.');    
            }
        }else{
            redirect('order-create.php','Something went wrong');
        }
    }

    if(isset($_POST['productIncDec'])){

        $productId = validate($_POST['product_id']);
        $quantity = validate($_POST['quantity']);

        $flag = false;
        foreach ($_SESSION['productItems'] as $key => $item) {
            if($item['product_id'] == $productId){

                $flag = true;
                $_SESSION['productItems'][$key]['quantity'] = $quantity; 
            }
        }

        if($flag){
            jsonResponse(200, 'success', 'Quantity updated');

        }else{

            jsonResponse(500, 'error', 'Something went wrong. Please re-fresh');

        }
    }

    if(isset($_POST['proceedToPlaceBtn'])){
        $phone = validate($_POST['cphone']);
        $payment_mode = validate($_POST['payment_mode']);

        // Checking for customer 
        $checkCustomer = mysqli_query($conn,"SELECT * FROM customers WHERE phone='$phone' LIMIT 1");
        if($checkCustomer){
            if(mysqli_num_rows($checkCustomer) > 0){
                $_SESSION['invoice_no'] = "INV-".rand(111111,9999999);
                $_SESSION['cphone'] = $phone;
                $_SESSION['payment_mode'] = $payment_mode;
                jsonResponse(200, 'success', 'Customer Found');

            }else{

                $_SESSION['cphone'] = $phone;
                jsonResponse(404, 'warning', 'Customer not found');

            }
        }
        else{
            jsonResponse(500, 'error', 'Something went wrong');
        }

    }


    // if customer not found then we will Save from Modal data into customers table
    if(isset($_POST['saveCustomerBtn'])){

        $name = validate($_POST['name']);
        $email = validate($_POST['email']);
        $phone = validate($_POST['phone']);

        if($name != '' && $phone != ''){

            $data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
            ];

            $result = insert('customers',$data);
            if($result){

                jsonResponse(200, 'success', 'Customer created successfully.');

            }else{
                jsonResponse(500, 'error', 'Something went Wrong.');
            }

        }else{

            jsonResponse(422, 'warning', 'Please fill required fields.');

        }
    }


    // Save order 
    if(isset($_POST['saveOrder'])){

        $phone = validate($_SESSION['cphone']);
        $invoice_no = validate($_SESSION['invoice_no']);
        $payment_mode = validate($_SESSION['payment_mode']);
        $order_place_by_id = $_SESSION['loggedInUser']['user_id'];

        $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone='$phone' LIMIT 1");
        
        if(!$checkCustomer){
            jsonResponse(500,'error','Something went wrong!');
        }

        if(mysqli_num_rows($checkCustomer) > 0){

            $customerData = mysqli_fetch_assoc($checkCustomer);

            if(!isset($_SESSION['productItems'])){

                jsonResponse(404,'warning','No Items to place order!');
            }

            $sessionProducts = $_SESSION['productItems'];
            
            $totalAmount = 0;
            foreach ($sessionProducts as $amtItem) {
                $totalAmount += $amtItem['price'] * $amtItem['quantity'];
            }

            $data = [
                'customer_id' => $customerData['id'],
                'tracking_no' => rand(11111,999999),
                'invoice_no' => $invoice_no,
                'total_amount' => $totalAmount,
                'order_date' => date('Y-m-d'),
                'order_status' => 'booked',
                'payment_mode' => $payment_mode,
                'order_place_by_id' => $order_place_by_id,
            ];

            $result = insert('orders',$data);
            $lastOrderId = mysqli_insert_id($conn);
            
            foreach ($sessionProducts as $prodItems) {

                $productId = $prodItems['product_id'];
                $price = $prodItems['price'];
                $quantity = $prodItems['quantity'];

                // Inserting order Items
                $dataOrderItem = [
                    'order_id' => $lastOrderId,
                    'product_id' => $productId,
                    'price' => $price,
                    'quantity' => $quantity,
                ];
                $orderItemQuery = insert('order_items', $dataOrderItem);

                // Checking for the books quantity and decreasing quantity and making total quantity
                $checkProductQtyQuery = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId'"); 
                $productQtyData = mysqli_fetch_assoc($checkProductQtyQuery);
                $totalProductQuantity =  $productQtyData['quantity'] = $quantity;
            
                $dataUpdate = [
                    'quantity' => $totalProductQuantity,
                ];

                $updateProductQty = update('products',$productId,$dataUpdate);

            }

            unset($_SESSION['productItemIds']);
            unset($_SESSION['productItems']);
            unset($_SESSION['cphone']);
            unset($_SESSION['payment_mode']);
            unset($_SESSION['invoice_no']);

            jsonResponse(200, 'success', 'Order placed successfully.');
        }else{

            jsonResponse(404, 'warning', 'No Customer Found!');
        }

    }



?>