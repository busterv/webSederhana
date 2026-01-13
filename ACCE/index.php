<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AcceGame - Topup Terpercaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-soft: #e3f2fd;
            --secondary-soft: #90caf9;
            --accent: #1976d2;
            --dark-blue: #0d47a1;
        }
        body { background-color: var(--primary-soft); font-family: 'Poppins', sans-serif; }
        .navbar { background-color: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .brand-logo { color: var(--accent); font-weight: bold; font-size: 1.5rem; text-decoration: none;}
        .card-game { 
            border: none; border-radius: 15px; transition: transform 0.3s; 
            background: white; overflow: hidden;
        }
        .card-game:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(144, 202, 249, 0.5); }
        .hero-section { background: linear-gradient(135deg, var(--accent), var(--secondary-soft)); color: white; padding: 60px 0; border-radius: 0 0 30px 30px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="brand-logo" href="index.php">💎 AcceGame</a>
            <div class="d-flex">
                <a href="cek_transaksi.php" class="btn btn-outline-primary btn-sm rounded-pill">Cek Pesanan</a>
            </div>
        </div>
    </nav>

    <div class="hero-section text-center mb-5">
        <div class="container">
            <h1>Top Up Game Favoritmu</h1>
            <p>Cepat, Aman, dan Terpercaya. Layanan 24 Jam.</p>
        </div>
    </div>

    <div class="container mb-5">
        <div class="container mb-5" style="margin-top: -50px; position: relative; z-index: 10;">
    <div class="row g-3"> <?php
        $stmt = $pdo->query("SELECT * FROM games");
        while ($row = $stmt->fetch()) {
        ?>
        <div class="col-6 col-md-3 col-lg-2"> 
            <a href="order.php?game=<?= $row['slug'] ?>" class="text-decoration-none text-dark">
                <div class="card card-game h-100 shadow-sm border-0">
                    <div style="aspect-ratio: 1/1; overflow: hidden; border-radius: 15px 15px 0 0;">
                        <img src="<?= $row['image_url'] ?>" class="w-100 h-100 object-fit-cover" alt="<?= $row['name'] ?>">
                    </div>
                    <div class="card-body p-2 text-center">
                        <h6 class="card-title fw-bold text-truncate mb-1" style="font-size: 0.9rem;"><?= $row['name'] ?></h6>
                        <p class="text-muted small mb-2" style="font-size: 0.7rem;"><?= $row['publisher'] ?></p>
                        <button class="btn btn-outline-primary w-100 rounded-pill btn-sm" style="font-size: 0.7rem;">Top Up</button>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>
    </div>
</div>
    </div>

    <footer class="text-center py-4 text-muted">
        <small>&copy; 2025 AcceGame. All Rights Reserved.</small>
    </footer>

</body>
</html>