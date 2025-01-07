<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Admin</title>
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

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="card-title mb-4">Selamat Datang di Panel Admin</h1>
                    <p class="card-text">Silakan pilih menu di atas untuk mengelola konten website.</p>
                    <div class="row mt-4">
                        <div class="col-md-4 mb-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <i class="fas fa-home fa-3x mb-3"></i>
                                    <h5>Kelola Hero</h5>
                                    <a href="edit_hero.php" class="btn btn-light mt-2">Edit Hero</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <i class="fas fa-box fa-3x mb-3"></i>
                                    <h5>Kelola Produk</h5>
                                    <a href="edit_products.php" class="btn btn-light mt-2">Edit Produk</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                    <h5>Pesanan</h5>
                                    <a href="lihat_pesanan.php" class="btn btn-light mt-2">Lihat Pesanan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
