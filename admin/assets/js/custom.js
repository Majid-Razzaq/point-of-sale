$(document).ready(function () {

// Alertify message code
    alertify.set('notifier','position', 'top-right');


    $(document).on('click', '.increment', function () {
        var quantityInput = $(this).closest('.qtyBox').find('.qty');
        var priceElement = $(this).closest('tr').find('.price');
        var totalElement = $(this).closest('tr').find('.total-price');
        var productId = $(this).closest('.qtyBox').find('.prodId').val();

        var currentValue = parseInt(quantityInput.val());
        if (!isNaN(currentValue)) {
            var qtyVal = currentValue + 1;
            quantityInput.val(qtyVal);
            var price = parseFloat(priceElement.text());
            var total = qtyVal * price;
            totalElement.text(total.toFixed(0));
            quantityIncDec(productId, qtyVal);
        }
    });

    $(document).on('click', '.decrement', function () {
        var quantityInput = $(this).closest('.qtyBox').find('.qty');
        var priceElement = $(this).closest('tr').find('.price');
        var totalElement = $(this).closest('tr').find('.total-price');
        var productId = $(this).closest('.qtyBox').find('.prodId').val();

        var currentValue = parseInt(quantityInput.val());
        if (!isNaN(currentValue) && currentValue > 1) {
            var qtyVal = currentValue - 1;
            quantityInput.val(qtyVal);
            var price = parseFloat(priceElement.text());
            var total = qtyVal * price;
            totalElement.text(total.toFixed(0)); 
            quantityIncDec(productId, qtyVal);
        }
    });

    function quantityIncDec(prodId, qty) {
        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: {
                'productIncDec': true,
                'product_id': prodId,
                'quantity': qty,
            },
            success: function (response) {
                var res = JSON.parse(response);
                if (res.status == 200) {
    
                    alertify.success(res.message);
                } else {
                    alertify.error(res.message);
                }
            }
        });
    }

    // Proceed to place order button click
    $(document).on('click','.proceedToPlace', function () {

        var cphone = $("#cphone").val();
        var payment_mode = $("#payment_mode").val();
        if(payment_mode == ''){
            swal("Select Payment Mode","Select your payment mode","warning");
            return false;
        }

        if(cphone == '' && !$.isNumeric(cphone)){
            swal("Enter Phone Number","Enter valid phone number","warning");
            return false;
        }

        var data = {
            'proceedToPlaceBtn' : true,
            'cphone' : cphone,
            'payment_mode' : payment_mode,
        };

        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: data,
            success: function (response) {

                var res = JSON.parse(response);
                if(res.status == 200){
                    
                    window.location.href = "order-summary.php";

                }else if(res.status == 404){

                    swal(res.message, res.message, res.status_type,{
                        buttons:{
                            catch:{
                                text: "Add Customer",
                                value: "catch"
                            },
                            cancel: "Cancel"
                        }
                    })
                    .then((value) =>{
                        switch(value){

                            case "catch":
                                $("#cphone").val(cphone);
                                $("#addCustomerModal").modal('show');
                                //console.log("Pop the customer add modal");
                                break;
                            default:

                        }
                    });
                }else{
                    swal(res.message, res.message, res.status_type);
                }
            }
        });

    });

    // Add Customer to Customers table
    $(document).on('click', '.saveCustomer', function () {
        var c_name = $("#c_name").val();
        var c_email = $("#c_email").val();
        var c_phone = $("#c_phone").val();
    
        if (c_name != '' && c_phone != '') {
    
            if ($.isNumeric(c_phone)) {
    
                var data = {
                    'saveCustomerBtn': true,
                    'name': c_name,
                    'email': c_email,
                    'phone': c_phone,
                };
    
                $.ajax({
                    type: "POST",
                    url: "orders-code.php",
                    data: data,
                    success: function (response) {
    
                        var res = JSON.parse(response);
                        if (res.status == 200) {
                            swal(res.message, res.message, res.status_type);
                            $("#addCustomerModal").modal('hide');
    
                        } else if (res.status == 422) {
                            swal(res.message, res.message, res.status_type);
                        } else {
    
                            swal(res.message, res.message, res.status_type);
    
                        }
    
                    }
                });
    
            } else {
                swal("Enter valid phone number.", "", "warning");
            }
    
        } else {
            swal("Please fill required fields.", "", "warning");
        }
    });
    

    // Save Order 
    $(document).on('click','#saveOrder', function () {
        
        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: {
                'saveOrder' : true,
            },
            success: function (response) {
                var res = JSON.parse(response);
                if(res.status == 200){

                    swal(res.message, res.message, res.status_type);
                    $("#orderPlaceSuccessMessage").text(res.message);
                    $("#orderSuccessModal").modal("show");
                    
                }else{

                    swal(res.message,res.message,res.status_type);
                }             
            }
        });

    });

});


    // Print code here
    function printMyBillingArea(){
        var divContents = document.getElementById("myBillingArea").innerHTML;
        var a = window.open('', '');
        a.document.write('<html><title>POS System</title>');
        a.document.write('<body style="font-family: fangsong;">');
        a.document.write(divContents);
        a.document.write('</body></html>');
        a.document.close();
        a.print();
        
    }

    window.jsPDF = window.jspdf.jsPDF;
    var docPDF = new jsPDF();

// Downlod as PDF
    function downloadPDF(invoiceNo){ 

        var elementHTML = document.querySelector("#myBillingArea");
        docPDF.html( elementHTML,{
            callback: function() {
                docPDF.save(invoiceNo+'.pdf');
            },
            x : 15,
            y : 15,
            width : 170,
            windowWidth : 650,

        });
     }



