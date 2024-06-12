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
    $invoice_number = $_POST['invoiceNo'];
    $invoice_date = $_POST['invoiceDate'];
    $invoice_data = json_decode($_POST['invoice_data'], true);

    // Check if Invoice number is unique for the current user
    $check_invoice = $conn->prepare("SELECT * FROM `invoices` WHERE invoice_number = ? AND customer_id = ?");
    $check_invoice->execute([$invoice_number, $user_id]);

    if ($check_invoice->rowCount() > 0) {
        $message[] = 'Invoice number already exists!';
    } else {
        $total = array_sum(array_column($invoice_data, 'net_total'));
        $discount = array_sum(array_column($invoice_data, 'discount'));
        $net_total = $total - $discount;

        $insert_invoice = $conn->prepare("INSERT INTO `invoices` (invoice_number, customer_id, invoice_date, total, discount, net_total) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_invoice->execute([$invoice_number, $user_id, $invoice_date, $total, $discount, $net_total]);

        $invoice_id = $conn->lastInsertId();

        foreach ($invoice_data as $row) {
            if (!empty($row['id']) && !empty($row['quantity']) && !empty($row['unit_price'])) {
                $product_id = $row['id'];
                $product_name = $row['name'];
                $unit_price = $row['unit_price'];
                $quantity = $row['quantity'];
                $total = $quantity * $unit_price;
                $discount = $row['discount'];
                $net_total = $total - $discount;

                $insert_invoice_item = $conn->prepare("INSERT INTO `invoice_items` (invoice_number, product_id, product_name, unit_price, quantity, total, discount, net_total, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insert_invoice_item->execute([$invoice_number, $product_id, $product_name, $unit_price, $quantity, $total, $discount, $net_total, $net_total]);
            }
        }

        // After adding invoice successfully
         foreach ($invoice_data as $row) {
            // Update stock table
               $update_stock = $conn->prepare("UPDATE stock SET quantity = quantity - ? WHERE product_id = ?");
               $update_stock->execute([$row['quantity'], $row['id']]);
         }

        $message[] = 'Invoice added successfully!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
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

<section class="add-invoice">
    <h1 class="title">Add Invoice</h1>
    
    <?php
    if (isset($message) && is_array($message)) {
        foreach ($message as $msg) {
            echo '<p class="message">'.$msg.'</p>';
        }
    }
    ?>
    
    <form id="invoiceForm" method="POST">
        <div class="form-control">
            <label for="invoiceNo">Invoice Number:</label>
            <input type="text" id="invoiceNo" name="invoiceNo" required>
        </div>
        <div class="form-control">
            <label for="invoiceDate">Invoice Date:</label>
            <input type="date" id="invoiceDate" name="invoiceDate" required>
        </div>
        <table id="invoiceTable">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product ID</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Discount</th>
                    <th>Net Total</th>
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
                    <td><input type="number" name="netTotal[]" readonly></td>

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
            <input type="hidden" name="invoice_data" id="invoice_data">
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

        const netTotal = quantity * unitPrice - discount;

        row.querySelector('input[name="netTotal[]"]').value = netTotal.toFixed(2);

        if (quantity > 0 && unitPrice > 0) {
            const isLastRow = row === row.parentElement.lastElementChild;
            if (isLastRow) {
                addRow();
            }
        }

        calculateTotalNet();
    }

    function calculateTotalNet() {
        const netTotalInputs = document.querySelectorAll('input[name="netTotal[]"]');
        let totalNet = 0;
        netTotalInputs.forEach(input => {
            totalNet += parseFloat(input.value) || 0;
        });
        document.getElementById('totalNet').value = totalNet.toFixed(2);
    }

    function addRow() {
        const table = document.getElementById('invoiceTable').getElementsByTagName('tbody')[0];
        const newRow = table.rows[0].cloneNode(true);

        Array.from(newRow.getElementsByTagName('input')).forEach(input => {
            input.value = '';
            if (input.name === 'name[]' || input.name === 'unitPrice[]' || input.name === 'netTotal[]') {
                input.setAttribute('readonly', 'readonly');
            }
        });
        table.appendChild(newRow);
    }

    function confirmCancel() {
        if (confirm("Are you sure you want to cancel?")) {
            document.getElementById('invoiceForm').reset();
            window.location.href = 'addinvoice.php';
        }
    }

    document.getElementById('invoiceForm').addEventListener('submit', function (e) {
        const table = document.getElementById('invoiceTable').getElementsByTagName('tbody')[0];
        const rows = Array.from(table.rows);
        const invoiceData = rows.map(row => {
            return {
                id: row.querySelector('input[name="id[]"]').value,
                name: row.querySelector('select[name="name[]"]').value,
                unit_price: row.querySelector('input[name="unitPrice[]"]').value,
                quantity: row.querySelector('input[name="quantity[]"]').value,
                discount: row.querySelector('input[name="discount[]"]').value,
                net_total: row.querySelector('input[name="netTotal[]"]').value
            };
        }).filter(row => row.id && row.quantity && row.unit_price);

        document.getElementById('invoice_data').value = JSON.stringify(invoiceData);
    });
</script>

</body>
</html>








