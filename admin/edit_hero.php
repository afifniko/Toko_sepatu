<?php
$json_file = '../hero_data.json';
$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'button_text' => $_POST['button_text'],
        'image' => $_POST['image']
    ];
    
    // Jika ada file gambar yang diupload
    if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] === 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["new_image"]["name"]);
        
        if (move_uploaded_file($_FILES["new_image"]["tmp_name"], $target_file)) {
            $data['image'] = $target_file;
        }
    }
    
    file_put_contents($json_file, json_encode($data, JSON_PRETTY_PRINT));
    $message = 'Data berhasil disimpan!';
}

// Baca data yang ada
$hero_data = json_decode(file_get_contents($json_file), true);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Hero Section</title>
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
        <h2>Edit Hero Section</h2>
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" class="form-control" name="title" value="<?php echo $hero_data['title']; ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" name="description"><?php echo $hero_data['description']; ?></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Teks Tombol</label>
                <input type="text" class="form-control" name="button_text" value="<?php echo $hero_data['button_text']; ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini</label>
                <img src="<?php echo $hero_data['image']; ?>" class="d-block mb-2" style="max-width: 200px">
                <input type="hidden" name="image" value="<?php echo $hero_data['image']; ?>">
                <input type="file" class="form-control" name="new_image">
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
