<?php

    require '../config/function.php';

    $paramResult = checkParamId('index');

    if (is_numeric($paramResult)) {
        $indexValue = validate($paramResult);

        if (isset($_SESSION['productItems']) && isset($_SESSION['productItemIds'])) {
            // Check if the 'indexValue' is within the valid range
            if ($indexValue >= 0 && $indexValue < count($_SESSION['productItems'])) {

                unset($_SESSION['productItems'][$indexValue]);
                unset($_SESSION['productItemIds'][$indexValue]);
                // Reset the array keys to maintain consistency
                $_SESSION['productItems'] = array_values($_SESSION['productItems']);
                $_SESSION['productItemIds'] = array_values($_SESSION['productItemIds']);
                redirect('order-create.php', 'Item Removed');
            } else {
                redirect('order-create.php', 'Invalid Item Index');
            }
        } else {
            redirect('order-create.php', 'There is no item');
        }
    } else {
        redirect('order-create.php', 'Param not numeric');
    }
?>
