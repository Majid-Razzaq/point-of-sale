<?php 

    require '../config/function.php';

    $paraResult = checkParamId('id');
    if(is_numeric($paraResult))
    {
        $adminId = validate($paraResult);
        $admin = getById('admins',$adminId);
        if($admin['status'] == 200){

            $adminDeleteRes = delete('admins',$adminId);
            if($adminDeleteRes){

                return redirect('admins.php','Admin Deleted Successfully.');

            }else{

                return redirect('admins.php','Something went wrong.');
            }

        }else{

            return redirect('admins.php','Something went wrong.');
        }
    }
    else{
        return redirect('admins.php',$admin['message']);
    }

?>