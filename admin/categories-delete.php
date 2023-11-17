<?php 

    require '../config/function.php';

    $paraResult = checkParamId('id');
    if(is_numeric($paraResult))
    {
        $categoryId = validate($paraResult);
        $category = getById('categories',$categoryId);
        if($category['status'] == 200){

            $categoryDeleteRes = delete('categories',$categoryId);
            if($categoryDeleteRes){

                return redirect('categories.php','Category Deleted Successfully.');

            }else{

                return redirect('categories.php','Something went wrong.');
            }

        }else{
            return redirect('categories.php',$categories['message']);
        }
    }
    else{
        return redirect('categories.php','Something went wrong.');
    }


?>