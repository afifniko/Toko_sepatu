<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Baca data pesanan
$orders = [];
if (file_exists('orders.json')) {
    $orders = json_decode(file_get_contents('orders.json'), true);
}

// Filter pesanan untuk user yang sedang login
$user_orders = array_filter($orders, function($order) {
    return isset($order['user']) && $order['user'] === $_SESSION['username'];
});

// Baca data produk
$products = json_decode(file_get_contents('featured_products.json'), true)['products'];
$products_by_id = [];
foreach ($products as $product) {
    $products_by_id[$product['id']] = $product;
}

// Baca data pembayaran
$payments = [];
if (file_exists('payments.json')) {
    $payments = json_decode(file_get_contents('payments.json'), true);
}

// Fungsi untuk mendapatkan data pembayaran berdasarkan order_id
function getPaymentByOrderId($payments, $order_id) {
    foreach ($payments as $payment) {
        if ($payment['order_id'] === $order_id) {
            return $payment;
        }
    }
    return null;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - TokoKita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">TokoKita</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-home"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <h2 class="mb-4">Riwayat Pesanan</h2>
        
        <?php if (empty($user_orders)): ?>
        <div class="alert alert-info">
            Anda belum memiliki pesanan.
        </div>
        <?php else: ?>
        <div class="row">
            <?php foreach ($user_orders as $order): ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>ID Pesanan: <?php echo htmlspecialchars($order['id']); ?></span>
                        <span class="badge bg-info">Sedang Dikirim</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <?php if (isset($products_by_id[$order['product_id']])): ?>
                                    <img src="uploads/<?php echo htmlspecialchars($products_by_id[$order['product_id']]['image']); ?>" 
                                         class="img-fluid rounded" 
                                         alt="<?php echo htmlspecialchars($products_by_id[$order['product_id']]['name']); ?>">
                                <?php else: ?>
                                    <div class="alert alert-warning">Gambar produk tidak tersedia</div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <h5 class="card-title">
                                    <?php echo isset($products_by_id[$order['product_id']]) ? 
                                        htmlspecialchars($products_by_id[$order['product_id']]['name']) : 
                                        'Produk tidak ditemukan'; ?>
                                </h5>
                                <p class="card-text">
                                    <strong>Tanggal Pesanan:</strong><br>
                                    <?php echo date('d F Y H:i', strtotime($order['tanggal'])); ?>
                                </p>
                                <p class="card-text">
                                    <strong>Nama Penerima:</strong><br>
                                    <?php echo htmlspecialchars($order['nama']); ?>
                                </p>
                                <p class="card-text">
                                    <strong>Nomor Telepon:</strong><br>
                                    <?php echo htmlspecialchars($order['telepon']); ?>
                                </p>
                                <p class="card-text">
                                    <strong>Alamat Pengiriman:</strong><br>
                                    <?php echo htmlspecialchars($order['alamat']); ?>
                                </p>
                                <p class="card-text">
                                    <strong>Harga:</strong><br>
                                    Rp <?php 
                                    if (isset($products_by_id[$order['product_id']]['price'])) {
                                        echo number_format((float)str_replace('.', '', $products_by_id[$order['product_id']]['price']), 0, ',', '.');
                                    } else {
                                        echo '0';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 