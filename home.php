
<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};
if(isset($_POST['add_to_wishlist'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $discount = isset($_POST['discount']) ? $_POST['discount'] : null; // Check if discount is set
   $p_weight = isset($_POST['p_weight']) ? $_POST['p_weight'] : null; // Check if p_weight is set
   $p_mweight = isset($_POST['p_mweight']) ? $_POST['p_mweight'] : null;
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

   $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   $check_wishlist_numbers->execute([$p_name, $user_id]);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_wishlist_numbers->rowCount() > 0){
      $message[] = 'already added to wishlist!';
   }elseif($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image, discount, weight, mweight) VALUES(?,?,?,?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image, $discount, $p_weight, $p_mweight]);
      $message[] = 'added to wishlist!';
   }

}


if(isset($_POST['add_to_cart'])) {
   // Retrieve form data
   $pid = $_POST['pid'];
   $p_name = $_POST['p_name'];
   $p_price = $_POST['p_price'];
   $discount = isset($_POST['discount']) ? $_POST['discount'] : null; // Check if discount is set
   $p_weight = isset($_POST['p_weight']) ? $_POST['p_weight'] : null; // Check if p_weight is set
   $p_mweight = isset($_POST['p_mweight']) ? $_POST['p_mweight'] : null; // Check if p_mweight is set
   $p_image = $_POST['p_image'];
   $p_qty = $_POST['p_qty'];

   // Prepare and execute queries
   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   } else {
      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$p_name, $user_id]);

      if($check_wishlist_numbers->rowCount() > 0){
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
         $delete_wishlist->execute([$p_name, $user_id]);
      }

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image, discount, weight, mweight) VALUES(?,?,?,?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image, $discount, $p_weight, $p_mweight]);
      $message[] = 'added to cart!';
   }
}




?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="home-bg">

   <section class="home">

      <div class="content">
         <span><b>Pussalla store</b></span>
         <h3>All the goods that you want</h3>
         
         <a href="products.php" class="btn">Products</a>
      </div>

   </section>

</div>

<section class="home-category">

   <h1 class="title">Shop by category</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/cat-1.jpg" alt="">
         <h3>Grains</h3>
         <a href="category.php?category=Grains" class="btn">View</a>
      </div>

      <div class="box">
         <img src="images/cat-2.png" alt="">
         <h3>Condiment/spices</h3>
         <a href="category.php?category=Condiment/spices" class="btn">View</a>
      </div>

      <div class="box">
         <img src="images/cat-3.jpg" alt="">
         <h3>Oil/Vinegars</h3>
         <a href="category.php?category=Oil/Vinegars" class="btn">View</a>
      </div>

      <div class="box">
         <img src="images/cat-4.jpg" alt="">
         <h3>other</h3>
         <a href="category.php?category=other" class="btn">View</a>
      </div>

   </div>

</section>
<?php include 'discount.php'; ?>
<section class="products">

   <h1 class="title">Latest Products</h1>

   <div class="box-container">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" class="box" method="POST">
      <div class="price"><span><?= $fetch_products['weight']; ?></span><span><?= $fetch_products['mweight']; ?></span> <br>Rs <span><?= $fetch_products['price']; ?></span>/-</div>
      <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="p_weight" value="<?= $fetch_products['weight']; ?>">
      <input type="hidden" name="p_mweight" value="<?= $fetch_products['mweight']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
      <input type="number" min="1" value="1" name="p_qty" class="qty">
      <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">No products added yet!</p>';
   }
   ?>

   </div>

</section>







<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>