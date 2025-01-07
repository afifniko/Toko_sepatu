<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

// Generate order ID
$order_id = uniqid('ORD');

// Simpan data pesanan
$order = [
    'id' => $order_id,
    'user' => $_SESSION['username'],
    'product_id' => $_POST['product_id'],
    'nama' => $_POST['nama'],
    'telepon' => $_POST['telepon'],
    'alamat' => $_POST['alamat'],
    'tanggal' => date('Y-m-d H:i:s')
];

// Baca dan update file orders.json
$orders = [];
if (file_exists('orders.json')) {
    $orders = json_decode(file_get_contents('orders.json'), true);
}
$orders[] = $order;
file_put_contents('orders.json', json_encode($orders));

// Ambil data produk untuk menampilkan harga
$featured_products = json_decode(file_get_contents('featured_products.json'), true)['products'];
$product = null;
foreach ($featured_products as $p) {
    if ($p['id'] == $_POST['product_id']) {
        $product = $p;
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - TokoKita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Instruksi Pembayaran</h3>
                        
                        <div class="alert alert-info">
                            <h5>Total Pembayaran: Rp <?php echo number_format((float)str_replace('.', '', $product['price']), 0, ',', '.'); ?></h5>
                        </div>

                        <div class="mb-4">
                            <h5>Silakan transfer ke:</h5>
                            <div class="border p-3 rounded">
                                <p class="mb-2"><strong>Bank BCA</strong></p>
                                <p class="mb-2"><strong>No. Rekening:</strong> 012345</p>
                                <p class="mb-0"><strong>Atas Nama:</strong> Shoes Store</p>
                            </div>
                        </div>

                        <form action="process_payment.php" method="POST">
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                            <input type="hidden" name="total_harga" value="<?php echo str_replace('.', '', $product['price']); ?>">
                            
                            <div class="mb-3">
                                <label class="form-label">Nama Pengirim</label>
                                <input type="text" class="form-control" name="nama_pengirim" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Nomor Rekening</label>
                                <input type="text" class="form-control" name="nomor_rekening" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Konfirmasi Pembayaran</button>
                        </form>

                        <div class="text-center mt-3">
                            <small class="text-muted">Setelah melakukan pembayaran, silakan konfirmasi dengan mengisi form di atas</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 