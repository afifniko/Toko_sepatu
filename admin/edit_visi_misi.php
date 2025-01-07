<?php
session_start();

// Fungsi untuk menyimpan data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'visi_misi_text' => $_POST['visi_misi_text'],
        'points' => [
            $_POST['point1'],
            $_POST['point2'],
            $_POST['point3']
        ],
        'image' => $_POST['current_image']
    ];

    // Handle upload gambar baru jika ada
    if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] === 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["new_image"]["name"]);
        if (move_uploaded_file($_FILES["new_image"]["tmp_name"], $target_file)) {
            $data['image'] = $target_file;
        }
    }

    file_put_contents('../visi_misi.json', json_encode($data, JSON_PRETTY_PRINT));
    $_SESSION['message'] = "Data berhasil disimpan!";
    header('Location: edit_visi_misi.php');
    exit;
}

// Baca data yang ada
$visi_misi = json_decode(file_get_contents('../visi_misi.json'), true);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Visi Misi</title>
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
        <h2 class="mb-4">Edit Visi dan Misi</h2>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Teks Visi & Misi</label>
                <textarea name="visi_misi_text" class="form-control" rows="4" required><?php echo htmlspecialchars($visi_misi['visi_misi_text']); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Point 1</label>
                <input type="text" name="point1" class="form-control" value="<?php echo htmlspecialchars($visi_misi['points'][0]); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Point 2</label>
                <input type="text" name="point2" class="form-control" value="<?php echo htmlspecialchars($visi_misi['points'][1]); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Point 3</label>
                <input type="text" name="point3" class="form-control" value="<?php echo htmlspecialchars($visi_misi['points'][2]); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini</label>
                <img src="../uploads/<?php echo htmlspecialchars($visi_misi['image']); ?>" class="d-block mb-2" style="max-width: 200px;">
                <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($visi_misi['image']); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Gambar Baru (Opsional)</label>
                <input type="file" name="new_image" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 