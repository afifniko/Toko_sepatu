<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];
    
    // Update status pesanan
    $orders = [];
    if (file_exists('../orders.json')) {
        $orders = json_decode(file_get_contents('../orders.json'), true);
        
        foreach ($orders as &$order) {
            if ($order['id'] === $order_id) {
                $order['status'] = $order_status;
                break;
            }
        }
        
        file_put_contents('../orders.json', json_encode($orders, JSON_PRETTY_PRINT));
    }
    
    // Update status pembayaran jika ada
    if (isset($_POST['payment_status'])) {
        $payment_status = $_POST['payment_status'];
        $payments = [];
        
        if (file_exists('../payments.json')) {
            $payments = json_decode(file_get_contents('../payments.json'), true);
            
            foreach ($payments as &$payment) {
                if ($payment['order_id'] === $order_id) {
                    $payment['status'] = $payment_status;
                    break;
                }
            }
            
            file_put_contents('../payments.json', json_encode($payments, JSON_PRETTY_PRINT));
        }
    }
    
    header('Location: index.php');
    exit();
}
?> 