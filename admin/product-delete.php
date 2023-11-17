<?php 

    require '../config/function.php';

    $paraResult = checkParamId('id');
    if(is_numeric($paraResult))
    {
        $productId = validate($paraResult);
        $product = getById('products',$productId);
        if($product['status'] == 200){

            $productDeleteRes = delete('products',$productId);
            if($productDeleteRes){

                $deleteImage = "../".$product['data']['image'];
                if(file_exists($deleteImage)){
                    unlink($deleteImage);
                }

                return redirect('products.php','Product Deleted Successfully.');

            }else{

                return redirect('products.php','Something went wrong.');
            }

        }else{
            return redirect('products.php',$categories['message']);
        }
    }
    else{
        return redirect('products.php','Something went wrong.');
    }


?>