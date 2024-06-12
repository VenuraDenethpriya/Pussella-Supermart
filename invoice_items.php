<?php
@include 'config.php';

if (isset($_GET['invoice_number'])) {
    $invoice_number = $_GET['invoice_number'];
    $query = $conn->prepare("SELECT * FROM invoice_items WHERE invoice_number = ?");
    $query->execute([$invoice_number]);

    $invoice_items = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($invoice_items);
} else {
    echo json_encode([]);
}
?>
