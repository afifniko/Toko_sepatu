<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $products = json_decode(file_get_contents('../featured_products.json'), true);
    
    // Tambah produk baru
    if (isset($_POST['add'])) {
        // Handle file upload untuk produk baru
        $target_dir = "../uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        if (isset($_FILES["new_image"]) && $_FILES["new_image"]["error"] == 0) {
            $file_extension = strtolower(pathinfo($_FILES["new_image"]["name"], PATHINFO_EXTENSION));
            $new_filename = uniqid() . '.' . $file_extension;
            $target_file = $target_dir . $new_filename;

            if (move_uploaded_file($_FILES["new_image"]["tmp_name"], $target_file)) {
                $newProduct = [
                    'id' => time(),
                    'name' => $_POST['new_name'],
                    'price' => $_POST['new_price'],
                    'image' => $target_file
                ];
                
                if (!isset($products['products'])) {
                    $products['products'] = [];
                }
                
                $products['products'][] = $newProduct;
                file_put_contents('../featured_products.json', json_encode($products, JSON_PRETTY_PRINT));
                $message = "Produk baru berhasil ditambahkan!";
            } else {
                $error = "Gagal mengunggah file gambar.";
            }
        }
    }
    
    // Update produk
    if (isset($_POST['update']) && isset($_POST['products'])) {
        if (isset($_FILES['product_image'])) {
            foreach ($_FILES['product_image']['tmp_name'] as $index => $tmp_name) {
                if (!empty($tmp_name) && $_FILES['product_image']['error'][$index] == 0) {
                    $target_dir = "../uploads/";
                    if (!file_exists($target_dir)) {
                        mkdir($target_dir, 0777, true);
                    }
                    
                    $file_extension = strtolower(pathinfo($_FILES["product_image"]["name"][$index], PATHINFO_EXTENSION));
                    $new_filename = uniqid() . '.' . $file_extension;
                    $target_file = $target_dir . $new_filename;

                    if (move_uploaded_file($tmp_name, $target_file)) {
                        $_POST['products'][$index]['image'] = $target_file;
                        
                        // Hapus file gambar lama jika ada
                        if (isset($products['products'][$index]['image']) && 
                            file_exists($products['products'][$index]['image'])) {
                            unlink($products['products'][$index]['image']);
                        }
                    }
                }
            }
        }
        
        $products['products'] = array_values($_POST['products']);
        file_put_contents('../featured_products.json', json_encode($products, JSON_PRETTY_PRINT));
        $message = "Produk berhasil diperbarui!";
    }
    
    // Hapus produk
    if (isset($_POST['delete'])) {
        $deleteIndex = $_POST['delete_index'];
        
        // Hapus file gambar
        if (isset($products['products'][$deleteIndex]['image']) && 
            file_exists($products['products'][$deleteIndex]['image'])) {
            unlink($products['products'][$deleteIndex]['image']);
        }
        
        array_splice($products['products'], $deleteIndex, 1);
        file_put_contents('../featured_products.json', json_encode($products, JSON_PRETTY_PRINT));
        $message = "Produk berhasil dihapus!";
    }
}

if (!file_exists('../featured_products.json')) {
    file_put_contents('../featured_products.json', json_encode(['products' => []], JSON_PRETTY_PRINT));
}

$products = json_decode(file_get_contents('../featured_products.json'), true)['products'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk Unggulan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
        }
    </style>
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Kelola Produk Unggulan</h2>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="fas fa-plus"></i> Tambah Produk
            </button>
        </div>
        
        <?php if (isset($message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($error); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <?php foreach ($products as $index => $product): ?>
                <div class="col-md-6 mb-4">
                    <div class="card position-relative">
                        <input type="hidden" name="delete_index" value="<?php echo $index; ?>">
                        <button type="submit" name="delete" class="btn btn-danger btn-sm delete-btn" 
                                onclick="return confirm('Yakin ingin menghapus produk ini?')">
                            <i class="fas fa-trash"></i>
                        </button>
                        
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" name="products[<?php echo $index; ?>][name]" 
                                       value="<?php echo htmlspecialchars($product['name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga</label>
                                <input type="text" class="form-control" name="products[<?php echo $index; ?>][price]" 
                                       value="<?php echo htmlspecialchars($product['price']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gambar Produk</label>
                                <input type="file" class="form-control" name="product_image[]" accept="image/*">
                                <input type="hidden" name="products[<?php echo $index; ?>][image]" 
                                       value="<?php echo htmlspecialchars($product['image']); ?>">
                                <div class="mt-2">
                                    <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                         class="img-thumbnail" style="max-height: 100px;" alt="Preview">
                                </div>
                            </div>
                            <input type="hidden" name="products[<?php echo $index; ?>][id]" 
                                   value="<?php echo $product['id']; ?>">
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <button type="submit" name="update" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Semua Perubahan
            </button>
        </form>
    </div>

    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" name="new_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="text" class="form-control" name="new_price" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" name="new_image" accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="add" class="btn btn-success">Tambah Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preview gambar saat file dipilih
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const imgPreview = this.parentElement.querySelector('img') || 
                                     this.nextElementSibling.querySelector('img');
                    imgPreview.src = URL.createObjectURL(this.files[0]);
                }
            });
        });
    </script>
</body>
</html>
