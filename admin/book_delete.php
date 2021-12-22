<?php
    include 'header.php';
     ?>
   <body>      
        <?php if (empty($_SESSION['current_user'])) { ?>
            <a href="login.php">Đăng nhập để vào trang Admin</a>
            <?php
         } else {
        
        include 'menu_sidebar.php';
        $currentUser = $_SESSION['current_user'];
        ?>

        <!-- PAGE CONTAINER-->
        <div class="page-container">

    <?php 
         
        include 'admin_navbar.php';
    ?>
        <!-- MAIN CONTENT -->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                    <?php
                    $error = false;
                    if (isset($_GET['id']) && !empty($_GET['id'])) {
                        $result = mysqli_query($con, "DELETE FROM `books` WHERE `id` = " . $_GET['id']);
                        if (!$result) {
                            $error = "Không thể xóa sản phẩm.";
                        }
                        mysqli_close($con);
                        // var_dump($error);
                        if ($error !== false) {
                    ?>
                            <div id="error-notify" class="box-content">
                                <h2>Thông báo</h2>
                                <h4><?= $error ?></h4>
                                <a href="./book.php">Danh sách sản phẩm</a>
                            </div>
                    <?php } else { ?>
                            <div id="success-notify" class="box-content">
                                <h2>Xóa sản phẩm thành công</h2>
                                <a href="./book.php">Danh sách sản phẩm</a>
                            </div>
                        <?php } ?>
                     <?php } ?>
 
                        </div>
                    </div>
                </div>
            </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>


    <!-- Main JS-->
    <script src="js/main.js"></script>

    <?php } ?>   <!-- end else -->

</body>

</html>
<!-- end document-->
