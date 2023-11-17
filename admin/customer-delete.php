<?php 

    require '../config/function.php';

    $paraResult = checkParamId('id');
    if(is_numeric($paraResult))
    {
        $customerId = validate($paraResult);
        $customer = getById('customers',$customerId);
        if($customer['status'] == 200){

            $customerDeleteRes = delete('customers',$customerId);
            if($customerDeleteRes){

                return redirect('customers.php','Customer Deleted Successfully.');

            }else{

                return redirect('customers.php','Something went wrong.');
            }

        }else{
            return redirect('customers.php',$customer['message']);
        }
    }
    else{
        return redirect('customers.php','Something went wrong.');
    }


?>