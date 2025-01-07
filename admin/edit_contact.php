<?php
$message = '';
$contact_data = [];

// Coba baca file contact.json
if (file_exists('../contact.json')) {
    $contact_data = json_decode(file_get_contents('../contact.json'), true);
}

// Set nilai default jika data kosong
if (!is_array($contact_data)) {
    $contact_data = [
        'phone' => '',
        'email' => ''
    ];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_contact = [
        'phone' => $_POST['phone'],
        'email' => $_POST['email']
    ];
    
    if (file_put_contents('../contact.json', json_encode($new_contact, JSON_PRETTY_PRINT))) {
        $message = 'Data kontak berhasil diperbarui!';
        $contact_data = $new_contact;
    } else {
        $message = 'Gagal memperbarui data kontak!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kontak - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Edit Informasi Kontak</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($message): ?>
                            <div class="alert alert-success"><?php echo $message; ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="phone" name="phone" 
                                       value="<?php echo htmlspecialchars($contact_data['phone'] ?? ''); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($contact_data['email'] ?? ''); ?>" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="../index.php" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
