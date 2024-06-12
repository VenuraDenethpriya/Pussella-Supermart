<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location: login.php');
    exit();
}

$query = "
    SELECT 
        s.product_id, 
        p.name as product_name, 
        s.quantity, 
        sup.name as supplier_name, 
        sup.email as supplier_email
    FROM 
        stock s
    JOIN 
        products p ON s.product_id = p.id
    JOIN 
        suppliers sup ON s.supplier_id = sup.id
    WHERE 
        s.quantity < 20
";

$statement = $conn->prepare($query);
$statement->execute();

$low_stock_products = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .notification-box {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .notification-title {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .notification-message {
            font-size: 18px;
            margin-bottom: 20px;
            color: #666;
            text-align: center;
        }

        .notification-buttons {
            text-align: center;
        }

        .notification-button {
            padding: 10px 20px;
            margin: 0 10px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .ignore-button {
            background-color: #ccc;
            color: #333;
        }

        .ignore-button:hover {
            background-color: #bbb;
        }

        .view-button {
            background-color: #007bff;
            color: #fff;
        }

        .view-button:hover {
            background-color: #0056b3;

         .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 10px;
         }

   .btn:hover {
    background-color: #45a049;
}

.ignore-button {
    background-color: #ccc;
    color: #333;
}

.ignore-button:hover {
    background-color: #bbb;
}

.view-button {
    background-color: #007bff;
    color: #fff;
}

.view-button:hover {
    background-color: #0056b3;
}

        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
    <div class="notification-box">
        <h2 class="notification-title">Low Stock Notification</h2>

        <?php if (!empty($low_stock_products)) : ?>
            <p class="notification-message">There are few products that you have to restock</p>

            <div class="notification-buttons">
               <button class="btn ignore-button" onclick="window.location.href='home.php'">Ignore</button>
               <button class="btn view-button" onclick="window.location.href='managestock.php'">View</button>
            </div>

        <?php else : ?>
            <p class="notification-message">No products with low stock levels.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
