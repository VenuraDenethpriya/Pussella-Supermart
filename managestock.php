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
    <title>Manage Stock</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 1.2rem; /* Increased font size */
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 15px; /* Increased padding */
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
            font-size: 1.3rem; /* Increased font size */
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        .message {
            color: red;
            font-weight: bold;
            font-size: 1.2rem; /* Increased font size */
        }

        a.email-link {
            color: #0000EE; /* Default link color */
            text-decoration: none;
        }

        a.email-link:hover {
            color: #FF0000; /* Color on hover */
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<section class="manage-stock">
    <h1 class="title">Manage Stock</h1>

    <?php
    if (!empty($low_stock_products)) {
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Product ID</th>';
        echo '<th>Product Name</th>';
        echo '<th>Quantity</th>';
        echo '<th>Supplier Name</th>';
        echo '<th>Supplier Email</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($low_stock_products as $product) {
            echo '<tr>';
            echo '<td>' . $product['product_id'] . '</td>';
            echo '<td>' . $product['product_name'] . '</td>';
            echo '<td>' . $product['quantity'] . '</td>';
            echo '<td>' . $product['supplier_name'] . '</td>';
            echo '<td><a class="email-link" href="mailto:' . $product['supplier_email'] . '">' . $product['supplier_email'] . '</a></td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p class="message">No products with low stock levels.</p>';
    }
    ?>
</section>

<?php include 'footer.php'; ?>

</body>
</html>



