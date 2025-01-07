<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment = [
        'order_id' => $_POST['order_id'],
        'nama_pengirim' => $_POST['nama_pengirim'],
        'nomor_rekening' => $_POST['nomor_rekening'],
        'total_harga' => $_POST['total_harga'],
        'tanggal_pembayaran' => date('Y-m-d H:i:s'),
        'status' => 'pending'
    ];

    // Simpan data pembayaran
    $payments = [];
    if (file_exists('payments.json')) {
        $payments = json_decode(file_get_contents('payments.json'), true);
    }
    $payments[] = $payment;
    file_put_contents('payments.json', json_encode($payments));

    // Redirect ke halaman riwayat pesanan
    header("Location: riwayat_pesanan.php");
    exit();
}

header("Location: index.php");
exit();
