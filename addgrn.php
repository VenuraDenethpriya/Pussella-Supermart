<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location: login.php');
    exit();
}

$message = []; // Ensure $message is an array

if (isset($_POST['complete'])) {
    $grn_number = $_POST['grnNo'];
    $grn_date = $_POST['grnDate'];
    $supplier_id = $_POST['supplier_id']; // New line to get supplier ID
    $grn_data = json_decode($_POST['grn_data'], true);

    // Check if GRN number is unique for the current user
    $check_grn = $conn->prepare("SELECT * FROM `grns` WHERE grn_number = ?");
    $check_grn->execute([$grn_number]);

    if ($check_grn->rowCount() > 0) {
        $message[] = 'GRN number already exists!';
    } else {
        $total = array_sum(array_column($grn_data, 'total'));
        $discount = array_sum(array_column($grn_data, 'discount'));
        $net_total = $total - $discount;

        $insert_grn = $conn->prepare("INSERT INTO `grns` (grn_number, supplier_id, grn_date, gross_amount, discount, net_total) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_grn->execute([$grn_number, $supplier_id, $grn_date, $total, $discount, $net_total]);

        $grn_id = $conn->lastInsertId();

        foreach ($grn_data as $row) {
            if (!empty($row['id']) && !empty($row['quantity']) && !empty($row['unit_price'])) {
                $product_id = $row['id'];
                $product_name = $row['name'];
                $quantity = $row['quantity'];
                $retail_price = $row['unit_price'];
                $discount = $row['discount'];
                $net_total = $row['total'];
                $cost = $retail_price - $discount;
                $total_cost = $cost * $quantity;

                $insert_grn_item = $conn->prepare("INSERT INTO `grn_items` (grn_number, product_id, product_name, quantity, retail_price, cost, total_cost, discount, net_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insert_grn_item->execute([$grn_number, $product_id, $product_name, $quantity, $retail_price, $cost, $total_cost, $discount, $net_total]);
            }
        }

        // After adding GRN successfully
        foreach ($grn_data as $row) {
            // Update stock table
            $update_stock = $conn->prepare("UPDATE stock SET quantity = quantity + ? WHERE product_id = ?");
            $update_stock->execute([$row['quantity'], $row['id']]);
        }

        $message[] = 'GRN added successfully!';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add GRN</title>
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
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        .btn-container {
            margin-top: 20px;
            text-align: center;
        }

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

        input[type="text"], input[type="number"], input[type="date"] {
            width: 150px;
            padding: 5px;
            margin: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        select {
            width: 160px;
            padding: 5px;
            margin: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .form-control {
            display: flex;
            margin-bottom: 15px;
            align-items: center;
        }

        .form-control label {
            margin-right: 10px;
            min-width: 100px;
            font-weight: bold;
        }

        .net-total-container {
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .net-total-container label {
            margin-right: 10px;
        }

        .net-total-container input[type="number"] {
            width: 200px;
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<section class="add-grn">
    <h1 class="title">Add GRN</h1>
    
    <?php
    if (isset($message) && is_array($message)) {
        foreach ($message as $msg) {
            echo '<p class="message">'.$msg.'</p>';
        }
    }
    ?>
    
    <form id="grnForm" method="POST">
        <div class="form-control">
            <label for="grnNo">GRN Number:</label>
            <input type="text" id="grnNo" name="grnNo" required>
        </div>
        <div class="form-control">
            <label for="grnDate">GRN Date:</label>
            <input type="date" id="grnDate" name="grnDate" required>
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


        <table id="grnTable">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product ID</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Discount</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="name[]" onchange="fetchProductDetails(this)">
                            <option value="">Select Product</option>
                            <?php
                            // Fetch product names from the database and populate the dropdown
                            $product_names_query = $conn->query("SELECT name FROM products");
                            while ($product = $product_names_query->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $product['name'] . '">' . $product['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <td><input type="text" name="id[]" readonly></td>
                    <td><input type="number" name="unitPrice[]" readonly></td>
                    <td><input type="number" name="quantity[]" oninput="calculateRow(this)"></td>
                    <td><input type="number" name="discount[]" oninput="calculateRow(this)"></td>
                    <td><input type="number" name="total[]" readonly></td>
                </tr>
            </tbody>
        </table>
        <div class="net-total-container">
            <label for="totalNet">Total Net Total:</label>
            <input type="number" id="totalNet" name="totalNet" readonly>
        </div>
        <div class="btn-container">
            <button type="submit" class="btn" name="complete">Complete</button>
            <button type="button" class="btn" onclick="confirmCancel()">Cancel</button>
            <input type="hidden" name="grn_data" id="grn_data">
        </div>
    </form>
</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>
<script>
    function fetchProductDetails(element) {
        const selectedProductName = element.value;
        // Fetch product details based on the selected product name
        fetch(`fetch_product_id.php?name=${selectedProductName}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Fill other fields with product details
                    const row = element.closest('tr');
                    row.querySelector('input[name="id[]"]').value = data.id;
                    row.querySelector('input[name="unitPrice[]"]').value = data.price;
                } else {
                    alert('Product not found');
                    console.error('Product not found for Name:', selectedProductName);
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    }

    function calculateRow(element) {
        const row = element.closest('tr');
        const quantity = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0;
        const unitPrice = parseFloat(row.querySelector('input[name="unitPrice[]"]').value) || 0;
        const discount = parseFloat(row.querySelector('input[name="discount[]"]').value) || 0;

        const total = quantity * unitPrice - discount;

        row.querySelector('input[name="total[]"]').value = total.toFixed(2);

        if (quantity > 0 && unitPrice > 0) {
            const isLastRow = row === row.parentElement.lastElementChild;
            if (isLastRow) {
                addRow();
            }
        }

        calculateTotalNet();
    }

    function calculateTotalNet() {
        const totalInputs = document.querySelectorAll('input[name="total[]"]');
        let totalNet = 0;
        totalInputs.forEach(input => {
            totalNet += parseFloat(input.value) || 0;
        });
        document.getElementById('totalNet').value = totalNet.toFixed(2);
    }

    function addRow() {
        const table = document.getElementById('grnTable').getElementsByTagName('tbody')[0];
        const newRow = table.rows[0].cloneNode(true);

        Array.from(newRow.getElementsByTagName('input')).forEach(input => {
            input.value = '';
            if (input.name === 'name[]' || input.name === 'unitPrice[]' || input.name === 'total[]') {
                input.setAttribute('readonly', 'readonly');
            }
        });
        table.appendChild(newRow);
    }

    function confirmCancel() {
        if (confirm("Are you sure you want to cancel?")) {
            document.getElementById('grnForm').reset();
            window.location.href = 'addgrn.php';
        }
    }

    document.getElementById('grnForm').addEventListener('submit', function (e) {
        const table = document.getElementById('grnTable').getElementsByTagName('tbody')[0];
        const rows = Array.from(table.rows);
        const grnData = rows.map(row => {
            return {
                id: row.querySelector('input[name="id[]"]').value,
                name: row.querySelector('select[name="name[]"]').value,
                unit_price: row.querySelector('input[name="unitPrice[]"]').value,
                quantity: row.querySelector('input[name="quantity[]"]').value,
                discount: row.querySelector('input[name="discount[]"]').value,
                total: row.querySelector('input[name="total[]"]').value
            };
        }).filter(row => row.id && row.quantity && row.unit_price);

        document.getElementById('grn_data').value = JSON.stringify(grnData);
    });
</script>

</body>
</html>

















