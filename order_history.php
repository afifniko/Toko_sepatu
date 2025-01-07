<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$orders = [];
if (file_exists('orders.json')) {
    $orders = json_decode(file_get_contents('orders.json'), true);
}

// Filter pesanan untuk user yang sedang login
$user_orders = array_filter($orders, function($order) {
    return $order['username'] === $_SESSION['username'];
});
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - TokoKita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4">Riwayat Pesanan</h2>
        
        <?php foreach ($user_orders as $order): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Order ID: <?php echo htmlspecialchars($order['order_id']); ?></h5>
                <p>Tanggal Pembayaran: <?php echo htmlspecialchars($order['payment_date']); ?></p>
                <p>Status: <?php echo htmlspecialchars($order['status']); ?></p>
                <p>Total: Rp <?php echo htmlspecialchars($order['price']); ?></p>
                <p>Metode Pembayaran: <?php echo htmlspecialchars($order['payment_method']); ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html> 