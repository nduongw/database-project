
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<?php 
    include 'header.php';
?>
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
img {
  display: block;
  margin-left: auto;
  margin-right: auto;
}

#bottom-pagination{
    text-align: left;
    margin-top: 15px;
}
.page-item{
    border: 1px solid #ccc;
    padding: 5px 9px;
    color: #333;
}
.current-page{
    background-color: var(--green);
    border: 1px solid var(--white);
    color: var(--white);
    font-weight: 600;
}
table {
  border-collapse: collapse;
  border-radius: 5px;
  overflow: hidden;
  box-shadow: 0px 2px 5px 0px rgb(0 0 0 / 10%);
}
thead tr {
        background-color: #333;
        color: #fff;
      }

td {
  /* border: 1px solid #343a40; */
  padding: 16px 24px;
  text-align: left;
  
}
#table-row:nth-child(odd) {
  background-color: #fff;
}

#table-row:nth-child(even) {
  background-color: #f5f5f5;
}
</style>

<!-- <hr> -->
<div class="container bootstrap snippet">
    <div class="row">
  		<div class="col-sm-4">
        <div class="text-center">  
            <h1> <?= $currentUser['first_name']." ".$currentUser['last_name']?> </h1>
        </div>
      </div>
    </div>
    <!-- row -->
      
    <div class="row">
  		<div class="col-sm-4"><!--left col-->
        <div class="text-center">
          <img src="<?= $currentUser['avatar'] ?>" class="avatar img-circle img-thumbnail" alt="avatar" style="width:200px;height:200px;">
        </div>

        <br>
          <div class="panel panel-default">
            <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i></div>
            <div class="panel-body"><a href="http://bootnipets.com">bootnipets.com</a></div>
          </div>
          
          <ul class="list-group">
            <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Shares</strong></span> 125</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Likes</strong></span> 13</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Posts</strong></span> 37</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Followers</strong></span> 78</li>
          </ul> 
               
          <div class="panel panel-default">
            <div class="panel-heading">Social Media</div>
            <div class="panel-body">
            	<i class="fa fa-facebook fa-2x"></i> <i class="fa fa-github fa-2x"></i> <i class="fa fa-twitter fa-2x"></i> <i class="fa fa-pinterest fa-2x"></i> <i class="fa fa-google-plus fa-2x"></i>
            </div>
          </div>
        </div><!--/col-4-->
    	<div class="col-sm-8">
            <ul class="nav nav-tabs">
                <!-- <li class="active"><a data-toggle="tab" href="user_profile.php">Thông tin</a></li> -->
                <li><a href="uif_profile.php">Cập nhật Thông tin</a></li>
                <li><a href="uif_passedit.php" >Đổi mật khẩu </a></li>
                <li style = "background-color :#ddd"><a href="uif_favorite.php" >Yêu thích</a></li>
                <li><a href="uif_orderhis.php" >Lịch sử mua hàng</a></li>
            </ul>
        <!-- <hr> -->

        <?php 
          $param = "";          // khoi tao bien param la chuoi trong filter de gan vs perpage va page
          $sortParam = "";      // khoi tao sortParam la chuoi trong filter ket hop vs order
          $orderConditon = "";  //  String chua dieu kien order : vd ORDER BY product.name ASC/DESC

          $user = $currentUser;
          $userid = $user['id'];

          $item_per_page = (!empty($_GET['per_page'])) ? $_GET['per_page'] : 3;
          $current_page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
          $offset = ($current_page - 1) * $item_per_page;

          $result = mysqli_query($con, "SELECT * FROM  books 
          INNER JOIN favorites ON books.id = favorites.book_id WHERE customer_id= $userid
          ORDER BY books.id ASC
          LIMIT " . $item_per_page . " OFFSET " . $offset . " " );
          
          $totalRecords = mysqli_query($con, "SELECT * FROM  books 
          INNER JOIN favorites ON books.id = favorites.book_id WHERE customer_id= $userid ORDER BY books.id ASC");
          $totalRecords = $totalRecords->num_rows;
          $totalPages = ceil($totalRecords / $item_per_page);
          ?>
  
          <table class="table table-borderless table-striped table-earning">
          <?php include 'pagination.php'?>
          <br>
            <thead>
              <tr>
                <td style="text-align: center">ID</td>
                <td style="text-align: center">
                  Tên sách
                </td>
                <td style="text-align: center">Ảnh</td>
                <td style="text-align: center">Giảm giá</td>
                <td style="text-align: center">Giá </td>
                <td style="text-align: center">Xóa</td>
              </tr>
            </thead>
            <?php
           
            while ($row = mysqli_fetch_array($result)) {
              ?>
              
                <tr id="table-row">
                <td style="text-align: center"><?= $row['id'] ?></td>
                  <td>
                    <?= $row['tittle'] ?>
                  </td>
                  <td>
                    <img style="width: 80px;height: 100px;"
                      src="./<?= $row['image'] ?>" alt="<?= $row['tittle'] ?>" title="<?= $row['tittle']?>" >
                  </td>
                  <td style="text-align: center"><?=$row['discount'] ?></td>
                  <td style="text-align: center"><?=number_format($row['price'] - $row['discount'], 0, ",", ".") ?>đ</td>
                  <td style="text-align: center"><a class="fa fa-trash" href="./uif_favor_del.php?id=<?= $row['id'] ?>" ></a></td>
                    
                </tr>
             
            <?php } ?>
          </table>
      </div><!--/col-8-->
    </div><!--/row-->
    
