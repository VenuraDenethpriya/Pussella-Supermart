<?php
@include 'config.php';

if (isset($_GET['name'])) {
    $product_name = $_GET['name'];
    $query = $conn->prepare("SELECT id, price FROM products WHERE name = ?");
    $query->execute([$product_name]);

    if ($query->rowCount() > 0) {
        $product = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode([
            'success' => true,
            'id' => $product['id'],
            'price' => $product['price']
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>

