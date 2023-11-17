<?php
    include('includes/header.php');

    if(isset($_SESSION['loggedIn']))
    {
       echo '<script>window.location.href="index.php"</script>';
    }
?>
<!-- justify-content-center -->

    <div class="py-5">
        <div class="container mt-5">
            <div class="row justify-content-center">


                <div class="col-md-5">
                    <div class="pos-img mt-3">
                        <img src="assets/images/images.png" alt="">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow rounded-4">

                    <!-- Message function -->
                    <?php alertMessage(); ?>
                    <!-- Message function -->

                        <div class="p-5">
                            <h4 class="text-dark mb-3">Sign into your POS System</h4>
                            <form action="login-code.php" method="post">
                                <div class="mb-3">
                                    <label for="">Enter Email Id</label>
                                    <input type="email" name="email" class="form-control" required/>
                                </div>

                                <div class="mb-3">
                                    <label for="">Enter Password</label>
                                    <input type="password" name="password" class="form-control" required/>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" name="login" class="btn btn-primary mt-2">Sign In</button>
                                </div>



                            </form>
                        </div>
                    </div>
                </div>

         
            </div>
        </div>
    </div>


<?php
    include('includes/footer.php');?>
