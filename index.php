<?php
session_start();
// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoes  Store</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #e74c3c;
            --bg-light: #f8f9fa;
            --bg-dark: #343a40;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .nav-link {
            color: var(--primary-color);
            font-weight: 500;
            margin: 0 12px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--accent-color);
            transform: translateY(-2px);
        }

        .search-form {
            position: relative;
            width: 350px;
        }

        .search-form input {
            border-radius: 25px;
            padding: 10px 20px;
            border: 1px solid #e1e1e1;
            transition: all 0.3s ease;
        }

        .search-form input:focus {
            box-shadow: 0 0 15px rgba(231, 76, 60, 0.1);
            border-color: var(--accent-color);
        }

        .cart-icon {
            position: relative;
            padding: 8px;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--accent-color);
            color: white;
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 0.75rem;
            font-weight: bold;
        }

        .hero-section {
            background: linear-gradient(145deg, #ffffff 0%, var(--bg-light) 100%);
            padding: 5rem 0;
        }
        
        .card {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .social-links a {
            font-size: 1.5rem;
            margin: 0 10px;
            transition: all 0.3s ease;
            color: var(--bg-dark);
        }
        
        .social-links a:hover {
            color: var(--accent-color);
            transform: scale(1.2);
        }
        
        .flash-sale .card {
            border-radius: 15px;
            overflow: hidden;
        }
        
        .countdown .badge {
            font-size: 1.1rem;
            padding: 8px 15px;
            border-radius: 8px;
        }

        .btn-primary {
            background-color: var(--accent-color);
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }

        .section-title {
            font-weight: 700;
            margin-bottom: 3rem;
            position: relative;
            padding-bottom: 15px;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--accent-color);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">Shoes Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Produk</a>
                    </li>
                </ul>
                
                <form class="search-form d-flex me-3">
                    <input class="form-control" type="search" placeholder="Cari produk...">
                </form>
                
                <div class="d-flex align-items-center">
                    <a href="riwayat_pesanan.php" class="nav-link me-3">
                        <i class="fas fa-user"></i>
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </a>
                    <a href="logout.php" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <?php
    $hero_data = json_decode(file_get_contents('hero_data.json'), true);
    ?>
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-4 fw-bold mb-4"><?php echo htmlspecialchars($hero_data['title']); ?></h1>
                    <p class="lead mb-4"><?php echo htmlspecialchars($hero_data['description']); ?></p>
                    <a href="#produk" class="btn btn-primary btn-lg"><?php echo htmlspecialchars($hero_data['button_text']); ?></a>
                </div>
                <div class="col-md-6">
                    <img src="uploads/<?php echo htmlspecialchars($hero_data['image']); ?>" class="img-fluid rounded-3" alt="Shopping">
                </div>
            </div>
        </div>
    </div>

    <!-- Fitur Unggulan -->
    <?php
    $features = json_decode(file_get_contents('features.json'), true)['features'];
    ?>
    <section class="features py-5 bg-white">
        <div class="container">
            <h2 class="text-center section-title">Fitur Unggulan Kami</h2>
            <div class="row">
                <?php foreach ($features as $feature): ?>
                <div class="col-md-4 mb-4">
                    <div class="p-4 bg-light rounded-3 h-100 text-center">
                        <i class="<?php echo htmlspecialchars($feature['icon']); ?> text-danger mb-3" style="font-size: 2.5rem;"></i>
                        <h4 class="mb-3"><?php echo htmlspecialchars($feature['title']); ?></h4>
                        <p class="text-muted"><?php echo htmlspecialchars($feature['description']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Visi dan Misi -->
    <?php $visi_misi = json_decode(file_get_contents('visi_misi.json'), true); ?>
    <section class="vision-mission py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="uploads/<?php echo htmlspecialchars($visi_misi['image']); ?>" class="img-fluid rounded-3 shadow" alt="Tim Kami">
                </div>
                <div class="col-md-6">
                    <h2 class="section-title text-start">Visi dan Misi Kami</h2>
                    <p class="lead mb-4"><?php echo htmlspecialchars($visi_misi['visi_misi_text']); ?></p>
                    
                    <?php foreach ($visi_misi['points'] as $point): ?>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-check-circle text-primary me-3" style="font-size: 1.5rem;"></i>
                        <span class="fs-5"><?php echo htmlspecialchars($point); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Produk Unggulan -->
    <section class="featured-products py-5">
        <div class="container">
            <h2 class="text-center section-title">Produk Unggulan</h2>
            <div class="row g-4">
                <?php
                $featured_products = json_decode(file_get_contents('featured_products.json'), true)['products'];
                foreach ($featured_products as $product):
                ?>
                <div class="col-6 col-md-3">
                    <div class="card h-100">
                        <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text text-muted">Rp <?php echo htmlspecialchars($product['price']); ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="checkout.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="btn btn-primary">Beli</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Kontak -->
    <?php
    $contact_data = json_decode(file_get_contents('contact.json'), true);
    ?>
    <section class="contact py-5 bg-dark text-white">
        <div class="container">
            <h2 class="text-center mb-5">Kontak</h2>
            <div class="row justify-content-center">
                <!-- Telepon -->
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark text-white text-center h-100 border-0">
                        <div class="card-body">
                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-phone fa-2x text-white"></i>
                            </div>
                            <h4>Telepon</h4>
                            <p class="mb-0"><?php echo htmlspecialchars($contact_data['phone']); ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Email -->
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark text-white text-center h-100 border-0">
                        <div class="card-body">
                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-envelope fa-2x text-white"></i>
                            </div>
                            <h4>Email</h4>
                            <p class="mb-0"><?php echo htmlspecialchars($contact_data['email']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3">
                    <h5 class="fw-bold mb-3">TokoKita</h5>
                    <p>Tempat belanja online terpercaya dengan berbagai produk berkualitas.</p>
                </div>
                <div class="col-md-3">
                    <h5 class="fw-bold mb-3">Layanan Pelanggan</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Cara Pembelian</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Pengiriman</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Pembayaran</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="fw-bold mb-3">Tentang Kami</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Tentang TokoKita</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Karir</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="fw-bold mb-3">Ikuti Kami</h5>
                    <div class="social-links">
                        <a href="#" class="text-light"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
