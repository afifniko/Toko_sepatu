<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input
    if (empty($_POST['nama']) || empty($_POST['telepon']) || empty($_POST['alamat']) || empty($_POST['product_id'])) {
        die("Semua field harus diisi!");
    }

    // Simpan pesanan (contoh sederhana menggunakan file JSON)
    $order = [
        'id' => uniqid(),
        'user' => $_SESSION['username'],
        'product_id' => $_POST['product_id'],
        'nama' => $_POST['nama'],
        'telepon' => $_POST['telepon'],
        'alamat' => $_POST['alamat'],
        'tanggal' => date('Y-m-d H:i:s'),
        'status' => 'Dalam Proses'
    ];

    // Baca file orders.json jika ada
    $orders = [];
    if (file_exists('orders.json')) {
        $orders = json_decode(file_get_contents('orders.json'), true);
    }

    // Tambahkan pesanan baru
    $orders[] = $order;

    // Simpan kembali ke file
    file_put_contents('orders.json', json_encode($orders, JSON_PRETTY_PRINT));

    // Redirect ke halaman sukses
    header("Location: order_success.php?order_id=" . $order['id']);
    exit();
} else {
    header("Location: index.php");
    exit();
}
?> 