<?php 
    include 'header.php' ;


    if(isset($_POST['content']) && isset($_POST['tittle']) ){
        $tittle = $_POST['tittle'];
        $content = $_POST['content'];

        if(isset($_SESSION['current_user'] )){
            $book_id = $_GET['id'];
            $user_id = $currentUser['id'];
            // var_dump($book_id,$user_id,$tittle,$content);exit;
             $result = mysqli_query($con, "INSERT INTO `reviews` (`id`, `book_id`, `customer_id`, `rating`, `tittle` , `content`, `created_date`, `last_updated`)
             VALUES (NULL, '$book_id', '$user_id', NULL, '$tittle' ,'$content', " . time() . ", " . time() . ");");

        echo"<script>alert('Bình luận của bạn đã được gửi!')</script>";
        }
    }

    $result = mysqli_query($con, "SELECT * FROM `books` WHERE `id` = ".$_GET['id']);
    $book = mysqli_fetch_assoc($result);
    // var_dump($book);exit;
    $imgLibrary = mysqli_query($con, "SELECT * FROM `books_library` WHERE `book_id` = ".$_GET['id']);    // ket noi voi thu vien anh
    $book['images'] = mysqli_fetch_all($imgLibrary, MYSQLI_ASSOC);   // lay ra nhieu anh gan cho book[images]   ( # voi book[image] )
    $row_id = $book['id'];
?>   

        <link rel="stylesheet" href="./assets/css/book_detail.css">
        <link rel="stylesheet" href="./assets/js/book.js">

        <div class="container">
        <hr>
            <div class="card">
            	<div class="row">
            		<aside class="col-sm-5 border-right">
                  <article class="gallery-wrap"> 
                    <div class="img-big-wrap" >
                      <a href="#"><img src="<?=$book['image']?>"></a>
                    </div> <!-- book - image // -->

                  <?php if(!empty($book['images'])){ ?>
                    <div class="img-small-wrap" style="margin-top:20px;">
                      <?php foreach($book['images'] as $img) { ?>
                        <div class="item-gallery"> <img src="<?=$img['path']?>" > </div>
                      <?php } ?>
                    </div> <!-- slider-nav.// -->
                  <?php } ?>  

                  </article> <!-- gallery-wrap .end// -->
            		</aside>

            		<aside class="col-sm-7">
                  <article class="card-body p-5">
            	      <h3 class="product-name"><?= $book['tittle']?></h3>
            
                    <p class="author-detail-wrap" style="margin-top:20px;"> 
                      <span class="category">Tác giả: </span> 
                      <span class="category-info price h3 text-info"> 
                        <?php
                          $author = mysqli_query($con, "SELECT authors.first_name,authors.last_name
                                                      FROM `books_authors`  INNER JOIN `authors` ON books_authors.author_id = authors.id
                                                                          INNER JOIN `books` ON books_authors.book_id = books.id
                                                      WHERE `books_authors`.`book_id` = $row_id                    
                                                                    ");  
                          while ($row2 = mysqli_fetch_array($author)){ ?>
                              <span><?= $row2['first_name']." ".$row2['last_name'].","?></span>
                        <?php } ?>
                    	</span> 
                    </p> <!-- author-detail-wrap .// -->

                    <p class="publisher-detail-wrap"> 
                        <span class="category">Nhà xuất bản: </span> 
                    	<span class="category-info price h3 text-info"> 
                    		<span class="">NXH xxx</span>
                    	</span> 
                    </p> <!-- publicsher-detail-wrap .// -->


                    <p class="price-detail-wrap"> 
                        <span class="category">Giá: </span> 
                    	<span class="category-info price h3 text-danger"> 
                    		<span class="num"><?= number_format($book['price'], 0, ",", ".") ?></span><span class="currency"> VNĐ</span>
                    	</span> 
                    </p> <!-- price-detail-wrap .// -->

                    <p class="discount-detail-wrap"> 
                        <span class="category">Tiết kiệm: </span> 
                    	<span class="category-info price h5 text-danger"> 
                    		<span class="num"><?= number_format(25000, 0, ",", ".") ?></span><span class="currency"> VNĐ</span><span>( 10% )</span>
                    	</span> 
                    </p> <!-- discount-detail-wrap .// -->

                    <p class="quantity-detail-wrap"> 
                        <span class="category">Tình trạng: </span> 

                        <?php if ($book['quantity'] > 0) { ?>
                        	<span class="category-info price h5 text-success"> Còn hàng</span>
                        <?php } else { ?> 
                          <span class="category-info price h5 text-warning"> Hết hàng</span>
                        <?php } ?>  
                        
                    </p> <!-- quantity-detail-wrap .// -->
                        
                        
                    <dl class="item-property">
                        <h4 class="category">Giới thiệu tóm tắt tác phẩm:</h4>
                        <dd>
                            <p class="overview-content"> <?= $book['content'] ?> </p>
                        </dd>
                    </dl>

                    <dl class="param param-feature">
                      <h4>Tags:</h4>
                      <a href="#" >Thể loại xxx ,</a> 
                      <a href="#" >Thể loại xxx ,</a> 
                      <a href="#" >Thể loại xxx ,</a> 
                      <a href="#" >Thể loại xxx ,</a> 
                    </dl>  <!-- item-property-hor .// -->

                    <hr>
            	      <div class="row">
            	      	<div class="col-sm-6">
                      <?php if ($book['quantity'] > 0) { ?>
                            <div class="amount-selection-container">
            	      		  <p class="category delete-margin">Số lượng:</p>
                          <form id="add-to-cart-form" action="cart.php?action=add" method="POST">
                              <div class="category row" ><input class="number-select" type="number" value="1" name="quantity[<?=$book['id']?>]" size="2" /></div> 
                            </div>

                            <div class="button-container">
                              <input class="buy-button btn btn-lg btn-primary text-uppercase" type="submit" value="Mua ngay"  />                       
                              <a href="#" class="cart-button btn btn-lg btn-outline-primary text-uppercase"> <i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng </a>
                              </div>
                            </form>  <!-- item-property .// -->
                            
                            
                      <?php } else { ?>
                          <span class="h5 text-warning">Sản phẩm hiện chưa có hàng</span>
                      <?php } ?>
            	      	</div> <!-- col.// -->

            		      
            	      </div> <!-- row.// -->
            	      

                  </article> <!-- card-body.// -->
            		</aside> <!-- col.// -->
            	</div> <!-- row.// -->
            </div> <!-- card.// -->

            <div class="review_card" style="margin-top:30px">
              <!-- RATING ROW -->
              <div class="row justify-content-left d-flex">
                <div class="col-md-4 d-flex flex-column">
                    <div class="rating-box">
                        <h1 class="pt-4">4.0</h1>
                        <p class="">out of 5</p>
                    </div>
                    <div> <span class="fa fa-star star-active mx-1"></span> <span class="fa fa-star star-active mx-1"></span> <span class="fa fa-star star-active mx-1"></span> <span class="fa fa-star star-active mx-1"></span> <span class="fa fa-star star-inactive mx-1"></span> </div>
                </div>
                <div class="col-md-8">
                    <div class="rating-bar0 justify-content-center">
                        <table class="text-left mx-auto">
                            <tr>
                                <td class="rating-label">Excellent</td>
                                <td class="rating-bar">
                                    <div class="bar-container">
                                        <div class="bar-5"></div>
                                    </div>
                                </td>
                                <td class="text-right">123</td>
                            </tr>
                            <tr>
                                <td class="rating-label">Good</td>
                                <td class="rating-bar">
                                    <div class="bar-container">
                                        <div class="bar-4"></div>
                                    </div>
                                </td>
                                <td class="text-right">23</td>
                            </tr>
                            <tr>
                                <td class="rating-label">Average</td>
                                <td class="rating-bar">
                                    <div class="bar-container">
                                        <div class="bar-3"></div>
                                    </div>
                                </td>
                                <td class="text-right">10</td>
                            </tr>
                            <tr>
                                <td class="rating-label">Poor</td>
                                <td class="rating-bar">
                                    <div class="bar-container">
                                        <div class="bar-2"></div>
                                    </div>
                                </td>
                                <td class="text-right">3</td>
                            </tr>
                            <tr>
                                <td class="rating-label">Terrible</td>
                                <td class="rating-bar">
                                    <div class="bar-container">
                                        <div class="bar-1"></div>
                                    </div>
                                </td>
                                <td class="text-right">0</td>
                            </tr>
                        </table>
                    </div>
                </div>
              </div><!-- end RATING ROW -->
            </div>      
            
            
            <!-- COMMENT FORM -->
            <div class="review_card">
              <div class="row justify-content-left d-flex">
                    <h2>COMMENT  : </h2>
                    <form method="post">
                        <textarea class="form-control" name="tittle" rows="1" placeholder="Tiêu đề" style="width: 500px;"></textarea>                            
                        <textarea class="form-control" name="content" rows="5" placeholder="Nội dung" style="width: 500px;"></textarea>                            
                        <input type="submit" class="btn btn-primary">
                    </form>
              </div><!-- end COMMENT FORM -->
            </div>  



        <?php
        $comments = mysqli_query($con, "SELECT customers.first_name, customers.last_name, reviews.* 
        FROM reviews
        INNER JOIN books ON reviews.book_id = books.id
        INNER JOIN customers ON reviews.customer_id = customers.id
        WHERE book_id = $row_id ");
        // $comments = mysqli_fetch_all($comments, MYSQLI_ASSOC);
            // var_dump($comments);exit;                      
        ?>

        <?php  while ($row_comment = mysqli_fetch_array($comments) ){  
            // var_dump($row_comment);exit;                      
        ?>
            <!-- USER COMMENT ROW -->
            <div class="review_card">
                <div class="row d-flex">
                    <div class=""> <img class="profile-pic" src="https://i.imgur.com/V3ICjlm.jpg"> </div>
                    <div class="d-flex flex-column">
                        <h3 class="mt-2 mb-0"> <?= $row_comment['first_name']." ".$row_comment['last_name'] ?> </h3>
                        <div>
                            <p class="text-left"><span class="text-muted">4.0</span> <span class="fa fa-star star-active ml-3"></span> <span class="fa fa-star star-active"></span> <span class="fa fa-star star-active"></span> <span class="fa fa-star star-active"></span> <span class="fa fa-star star-inactive"></span></p>
                        </div>
                    </div>
                    <div class="ml-auto">
                        <p class="text-muted pt-5 pt-sm-3"> <?= date('d/m/Y',$row_comment['created_date']) ?> </p>
                    </div>
                </div>
                <div class="row text-left">
                    <h4 class="blue-text mt-3"> <?= $row_comment['tittle'] ?></h4> 
                </div>
                <div class="row text-left">
                    <p class="content"> <?= $row_comment['content'] ?></p> </p>
                </div>
                <!-- <div class="row text-left"> <img class="pic" src="https://i.imgur.com/kjcZcfv.jpg"> <img class="pic" src="https://i.imgur.com/SjBwAgs.jpg"> <img class="pic" src="https://i.imgur.com/IgHpsBh.jpg"> </div> -->
                <div class="row text-left mt-4">
                    <div class="like mr-3 vote"> <img src="https://i.imgur.com/mHSQOaX.png"><span class="blue-text pl-2">20</span> </div>
                    <div class="unlike vote"> <img src="https://i.imgur.com/bFBO3J7.png"><span class="text-muted pl-2">4</span> </div>
                </div>
            </div><!-- end review card -->
        <?php } ?>


        </div>
        <!--container.//-->

        
    <!-- featured section starts  -->
    <section class="featured" id="featured">
    
        <h1 class="heading"> <span>Sản phẩm có liên quan</span> </h1>
    
        <div class="swiper featured-slider">
    
            <div class="swiper-wrapper">
    
                <div class="swiper-slide box">
                    <div class="icons">
                        <a href="#" class="fas fa-search"></a>
                        <a href="#" class="fas fa-heart"></a>
                        <a href="#" class="fas fa-eye"></a>
                    </div>
                    <div class="image">
                        <img src="./assets/image/book-2.png" alt="">
                    </div>
                    <div class="content">
                        <h3>featured books</h3>
                        <div class="price">$15.99 <span>$20.99</span></div>
                        <a href="#" class="button">add to cart</a>
                    </div>
                </div>

    
                <div class="swiper-slide box">
                    <div class="icons">
                        <a href="#" class="fas fa-search"></a>
                        <a href="#" class="fas fa-heart"></a>
                        <a href="#" class="fas fa-eye"></a>
                    </div>
                    <div class="image">
                        <img src="./assets/image/book-8.png" alt="">
                    </div>
                    <div class="content">
                        <h3>featured books</h3>
                        <div class="price">$15.99 <span>$20.99</span></div>
                        <a href="#" class="button">add to cart</a>
                    </div>
                </div>
    
                <div class="swiper-slide box">
                    <div class="icons">
                        <a href="#" class="fas fa-search"></a>
                        <a href="#" class="fas fa-heart"></a>
                        <a href="#" class="fas fa-eye"></a>
                    </div>
                    <div class="image">
                        <img src="./assets/image/book-10.png" alt="">
                    </div>
                    <div class="content">
                        <h3>featured books</h3>
                        <div class="price">$15.99 <span>$20.99</span></div>
                        <a href="#" class="button">add to cart</a>
                    </div>
                </div>
    
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>
    <!-- featured section ends -->        

    <!-- featured section starts  -->
    <section class="featured" id="featured">
    
        <h1 class="heading"> <span>Cùng tác giả</span> </h1>
    
        <div class="swiper featured-slider">
    
            <div class="swiper-wrapper">
    
                <div class="swiper-slide box">
                    <div class="icons">
                        <a href="#" class="fas fa-search"></a>
                        <a href="#" class="fas fa-heart"></a>
                        <a href="#" class="fas fa-eye"></a>
                    </div>
                    <div class="image">
                        <img src="./assets/image/book-1.png" alt="">
                    </div>
                    <div class="content">
                        <h3>featured books</h3>
                        <div class="price">$15.99 <span>$20.99</span></div>
                        <a href="#" class="button">add to cart</a>
                    </div>
                </div>

    
                <div class="swiper-slide box">
                    <div class="icons">
                        <a href="#" class="fas fa-search"></a>
                        <a href="#" class="fas fa-heart"></a>
                        <a href="#" class="fas fa-eye"></a>
                    </div>
                    <div class="image">
                        <img src="./assets/image/book-9.png" alt="">
                    </div>
                    <div class="content">
                        <h3>featured books</h3>
                        <div class="price">$15.99 <span>$20.99</span></div>
                        <a href="#" class="button">add to cart</a>
                    </div>
                </div>
    
                <div class="swiper-slide box">
                    <div class="icons">
                        <a href="#" class="fas fa-search"></a>
                        <a href="#" class="fas fa-heart"></a>
                        <a href="#" class="fas fa-eye"></a>
                    </div>
                    <div class="image">
                        <img src="./assets/image/book-10.png" alt="">
                    </div>
                    <div class="content">
                        <h3>featured books</h3>
                        <div class="price">$15.99 <span>$20.99</span></div>
                        <a href="#" class="button">add to cart</a>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <div class="icons">
                        <a href="#" class="fas fa-search"></a>
                        <a href="#" class="fas fa-heart"></a>
                        <a href="#" class="fas fa-eye"></a>
                    </div>
                    <div class="image">
                        <img src="./assets/image/book-5.png" alt="">
                    </div>
                    <div class="content">
                        <h3>featured books</h3>
                        <div class="price">$15.99 <span>$20.99</span></div>
                        <a href="#" class="button">add to cart</a>
                    </div>
                </div>
                <div class="swiper-slide box">
                    <div class="icons">
                        <a href="#" class="fas fa-search"></a>
                        <a href="#" class="fas fa-heart"></a>
                        <a href="#" class="fas fa-eye"></a>
                    </div>
                    <div class="image">
                        <img src="./assets/image/book-6.png" alt="">
                    </div>
                    <div class="content">
                        <h3>featured books</h3>
                        <div class="price">$15.99 <span>$20.99</span></div>
                        <a href="#" class="button">add to cart</a>
                    </div>
                </div>
    
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>


            
  </body>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script></body>
  <!-- <script src="./vendor/jquery/jquery.min.js"></script>
  <script src="./vendor/jquery/jquery.slim.min.js"></script>
  <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js'></script>
  <script type='text/javascript' src=''></script>
  <script type='text/javascript' src=''></script> -->


  <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    
    <!-- custom js file link  -->
  <script src="./assets/js/main.js"></script>
<style>
     * {
            padding: 0;
            margin: 0;
            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
            box-sizing: border-box;
            
        }
    .product-name {
        font-size: 2.2rem;
    }
    .category {
        font-size: 1.7rem;
        font-weight: 400;
    }
    .overview-content {
        font-size: 1.2rem;
        font-weight: 300;
    }
    .buy-button {
                height: 40px;
                width: 120px;
                font-size: 14px;
                font-weight: 600;
                background-color: #27ae60;
                color: #fff;
                text-decoration: none;
                cursor: pointer;
                
                border: 0;
                padding: 5px 10px;
                letter-spacing: 0.3px;
            }

    .buy-button:hover {
        background-color: #219150;
    }

    .category-info {
        font-size: 1.7rem;
    }

    .amount-selection-container {
        
        display: flex;
        gap: 3rem;
        align-items: center;
        
        margin-bottom: 4rem;
    }

    .number-select {
        border: 0.3px solid;
        text-align: center;
        width: 100px;
    }

    .delete-margin {
        margin: 0;
    }

    .cart-button {
        height: 40px;
        width: 240px;
        font-size: 14px;
        font-weight: 600;
        background-color: #f59f00;
        color: #fff;
        text-decoration: none;
        cursor: pointer;
        
        border: 0;
        padding: 5px 10px;
        letter-spacing: 0.3px;
        display: flex;
        justify-content:center;
        align-items: center;
    }

    .cart-button:hover {
        background-color: #f08c00;
    }
    .button-container {
        gap: 1rem;
        display: flex; 
        justify-content: space-between;
        margin-bottom: 1rem;
    }
</style>
</html>