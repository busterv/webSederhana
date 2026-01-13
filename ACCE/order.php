<?php 
include 'config.php'; 
$slug = $_GET['game'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM games WHERE slug = ?");
$stmt->execute([$slug]);
$game = $stmt->fetch();

if (!$game) die("Game tidak ditemukan!");

// Ambil Produk
$stmtProc = $pdo->prepare("SELECT * FROM products WHERE game_id = ?");
$stmtProc->execute([$game['id']]);
$products = $stmtProc->fetchAll();

// Ambil Metode Bayar
$stmtPay = $pdo->query("SELECT * FROM payment_methods");
$methods = $stmtPay->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Top Up <?= $game['name'] ?> - AcceGame</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .section-title { border-left: 5px solid #1976d2; padding-left: 10px; margin-bottom: 20px; color: #0d47a1; }
        .option-card { cursor: pointer; border: 2px solid transparent; }
        .option-radio:checked + .option-card { border-color: #1976d2; background-color: #e3f2fd; }
        .option-radio { display: none; }
        .game-header { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row">
            <div class="col-md-4">
                <div class="game-header text-center">
                    <img src="<?= $game['image_url'] ?>" class="img-fluid rounded mb-3" width="150">
                    <h3><?= $game['name'] ?></h3>
                    <p><?= $game['publisher'] ?></p>
                </div>
            </div>

            <div class="col-md-8">
                <form action="process_order.php" method="POST">
                    <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
                    
                    <div class="bg-white p-4 rounded shadow-sm mb-3">
                        <h5 class="section-title">1. Masukkan User ID</h5>
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text" name="user_id" class="form-control" placeholder="Contoh: 12345678 (1234)" required>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded shadow-sm mb-3">
                        <h5 class="section-title">2. Pilih Nominal</h5>
                        <div class="row g-2">
                            <?php foreach ($products as $p): ?>
                            <div class="col-4 col-md-4">
                                <input type="radio" name="product_id" id="prod-<?= $p['id'] ?>" value="<?= $p['id'] ?>" class="option-radio" required>
                                <label for="prod-<?= $p['id'] ?>" class="card option-card h-100 p-2 text-center">
                                    <small class="fw-bold d-block"><?= $p['item_name'] ?></small>
                                    <span class="text-primary">Rp <?= number_format($p['price'], 0, ',', '.') ?></span>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded shadow-sm mb-3">
                        <h5 class="section-title">3. Pembayaran</h5>
                        <div class="d-flex flex-column gap-2">
                            <?php foreach ($methods as $m): ?>
                            <div class="position-relative">
                                <input type="radio" name="payment_id" id="pay-<?= $m['id'] ?>" value="<?= $m['id'] ?>" class="option-radio" required>
                                <label for="pay-<?= $m['id'] ?>" class="card option-card p-3 d-flex flex-row justify-content-between align-items-center w-100">
                                    <span class="fw-bold"><?= $m['name'] ?></span>
                                    <small class="text-muted">+ Biaya Rp <?= number_format($m['admin_fee'], 0, ',', '.') ?></small>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="bg-white p-4 rounded shadow-sm mb-3">
                         <h5 class="section-title">4. Beli!</h5>
                         <input type="text" name="phone" class="form-control mb-3" placeholder="Nomor WhatsApp (Untuk Bukti)" required>
                         <button type="submit" class="btn btn-primary w-100 btn-lg fw-bold">BELI SEKARANG</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>