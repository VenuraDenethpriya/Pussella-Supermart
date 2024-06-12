<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

if (isset($_POST['submit'])) {

    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $p_name = $_POST['p_name'];
    $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);
    $p_price = $_POST['p_price'];
    $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
    $p_image = $_POST['p_image'];
    $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
    $weight = $_POST['weight'];
    $weight = filter_var($weight, FILTER_SANITIZE_STRING);
    $mweight = $_POST['mweight'];
    $mweight = filter_var($mweight, FILTER_SANITIZE_STRING);
    $discount = $_POST['discount'];
    $discount = filter_var($discount, FILTER_SANITIZE_STRING);

    $insert_product = $conn->prepare("INSERT INTO `products` (id, name, category, details, price, image, weight, mweight, discount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_product->execute([$pid, $p_name, $category, $details, $p_price, $p_image, $weight, $mweight, $discount]);
    $message[] = 'Product added successfully!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .add-product {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 16px; /* Increased label font size */
        }

        .form-group select,
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #ccc; /* Change border color */
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group textarea {
            height: 100px;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<section class="add-product">
    <h1 class="title">Add New Product</h1>
    <div class="form-container">
        <form action="" method="POST">
            <div class="form-group">
                <label for="pid">Product ID:</label>
                <input type="text" id="pid" name="pid" required>
            </div>
            <div class="form-group">
                <label for="p_name">Product Name:</label>
                <input type="text" id="p_name" name="p_name" required>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="Grains">Grains</option>
                    <option value="Condiment/Spices">Condiment/Spices</option>
                    <option value="Oil/Vinegars">Oil/Vinegars</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="details">Details:</label>
                <textarea id="details" name="details" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="supplier_id">Supplier ID:</label>
                <select id="supplier_id" name="supplier_id" required>
                    <?php
                    // Fetch supplier IDs from the database and populate the dropdown
                    $supplier_ids_query = $conn->query("SELECT id FROM suppliers");
                    while ($supplier = $supplier_ids_query->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $supplier['id'] . '">' . $supplier['id'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="p_price">Price:</label>
                <input type="number" id="p_price" name="p_price" required>
            </div>
            <div class="form-group">
                <label for="p_image">Image:</label>
                <input type="file" id="p_image" name="p_image" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="weight">Weight:</label>
                <input type="text" id="weight" name="weight" required>
            </div>
            <div class="form-group">
                <label for="mweight">MWeight:</label>
                <input type="text" id="mweight" name="mweight" required>
            </div>
            <div class="form-group">
                <label for="discount">Discount:</label>
                <input type="number" id="discount" name="discount" required>
            </div>
            <input type="submit" value="Add Product" class="btn" name="submit">
        </form>
    </div>
</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
