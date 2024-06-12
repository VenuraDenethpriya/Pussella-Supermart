<?php
@include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Stock</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <style>
      html, body {
         height: 100%;
         margin: 0;
         padding: 0;
      }
      body {
         display: flex;
         flex-direction: column;
      }
      .main-content {
         flex: 1;
         display: flex;
         justify-content: center;
         align-items: center;
      }
      .p-category {
         margin-top: auto;
      }
   </style>
</head>
<body>
   <?php include 'header.php'; ?>
   <br>
   <div class="main-content">
      <section class="p-category">
         <a href="addgrn.php">Add GRN</a>
         <a href="viewstock.php">View Stock</a>
         <a href="managestock.php">Manage Stock</a>
      </section>
   </div>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <?php include 'footer.php'; ?>
   <script src="js/script.js"></script>
</body>
</html>


