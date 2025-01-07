<?php
session_start();


// Baca data pesanan
$orders = [];
if (file_exists('../orders.json')) {
    $orders = json_decode(file_get_contents('../orders.json'), true);
}

// Baca data produk
$products = json_decode(file_get_contents('../featured_products.json'), true)['products'];
$products_by_id = [];
foreach ($products as $product) {
    $products_by_id[$product['id']] = $product;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Pesanan - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Menu Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="edit_hero.php">edit hero</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="edit_fitur.php">edit fitur</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="edit_visi_misi.php">edit visi misi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="edit_products.php">edit produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="edit_contact.php">edit contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="lihat_pesanan.php">Lihat Pesanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../login.php">Keluar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2>Daftar Pesanan</h2>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Tanggal</th>
                    <th>Pembeli</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Alamat</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($order['tanggal'])); ?></td>
                    <td>
                        <?php echo htmlspecialchars($order['nama']); ?><br>
                        <small><?php echo htmlspecialchars($order['telepon']); ?></small>
                    </td>
                    <td>
                        <?php 
                        if (isset($products_by_id[$order['product_id']])) {
                            echo htmlspecialchars($products_by_id[$order['product_id']]['name']);
                        } else {
                            echo 'Produk tidak ditemukan';
                        }
                        ?>
                    </td>
                    <td>
                        Rp <?php 
                        if (isset($products_by_id[$order['product_id']]['price'])) {
                            echo number_format((float)str_replace('.', '', $products_by_id[$order['product_id']]['price']), 0, ',', '.');
                        } else {
                            echo '0';
                        }
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($order['alamat']); ?></td>
                    <td><span class="badge bg-info">Sedang Dikirim</span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 