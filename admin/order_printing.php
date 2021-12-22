<?php
    include 'header.php';
     ?>
   <body>      
        <?php if (empty($_SESSION['current_user'])) { ?>
            <a href="login.php">Đăng nhập để vào trang Admin</a>
            <?php
         } else {
        
        // include 'menu_sidebar.php';
        $currentUser = $_SESSION['current_user'];
        ?>


    <?php 
        // include 'admin_navbar.php';
        
        $orders = mysqli_query($con, "SELECT orders.fullname, orders.address, orders.phone, orders.note, orders_details.*, books.tittle as book_tittle 
        FROM orders
        INNER JOIN orders_details ON Orders.id = orders_details.order_id
        INNER JOIN books ON books.id = orders_details.book_id
        WHERE orders.id = " . $_GET['id']);
        $orders = mysqli_fetch_all($orders, MYSQLI_ASSOC);
        // var_dump($orders);exit;
        }
        ?>
        <div id="order-detail-wrapper">
            <div id="order-detail">
                <h1>Chi tiết đơn hàng</h1>
                <label>Người nhận: </label><span> <?= $orders[0]['fullname'] ?></span><br/>
                <label>Điện thoại: </label><span> <?= $orders[0]['phone'] ?></span><br/>
                 <label>Địa chỉ: </label><span> <?= $orders[0]['address'] ?></span><br/>
                <hr/>
                <h3>Danh sách sản phẩm</h3>
                <ul>
                    <?php
                    $totalQuantity = 0;
                    $totalMoney = 0;
                    foreach ($orders as $row) {
                        ?>
                        <li>
                            <span class="item-name"><?= $row['book_tittle'] ?></span>
                            <span class="item-quantity"> - SL: <?= $row['quantity'] ?> quyển</span>
                        </li>
                        <?php
                        $totalMoney += ($row['price'] * $row['quantity']);
                        $totalQuantity += $row['quantity'];
                    }
                    ?>
                </ul>
                <hr/>
                <label>Tổng Số Lượng:</label> <?= $totalQuantity ?> quyển <br> <label>Tổng Giá trị:</label> <?= number_format($totalMoney, 0, ",", ".") ?> đ
                <p><label>Ghi Chú: </label><?= $orders[0]['note'] ?></p>
            </div>
        </div>
    </body>
</html>