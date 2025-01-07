<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - TokoKita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="text-center">
            <h1 class="display-4 text-success mb-4">🎉 Pesanan Berhasil!</h1>
            <p class="lead">Terima kasih telah berbelanja di TokoKita</p>
            <p>ID Pesanan Anda: <?php echo htmlspecialchars($_GET['order_id']); ?></p>
            <a href="riwayat_pesanan.php" class="btn btn-primary mt-3">Lihat Riwayat Pesanan</a>
        </div>
    </div>
</body>
</html> 