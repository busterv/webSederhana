<?php
include 'config.php';
$trx_id = $_GET['trx_id'] ?? '';

$stmt = $pdo->prepare("
    SELECT t.*, p.item_name, m.name as method_name, m.code 
    FROM transactions t
    JOIN products p ON t.product_id = p.id
    JOIN payment_methods m ON t.payment_method_id = m.id
    WHERE t.trx_id = ?
");
$stmt->execute([$trx_id]);
$trx = $stmt->fetch();

if (!$trx) die("Transaksi tidak ditemukan.");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Pembayaran - AceGame</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">Menunggu Pembayaran</h4>
                    </div>
                    <div class="card-body text-center">
                        <p class="text-muted">Nomor Pesanan: <strong><?= $trx['trx_id'] ?></strong></p>
                        <h1 class="text-primary my-4">Rp <?= number_format($trx['total_amount'], 0, ',', '.') ?></h1>
                        
                        <div class="alert alert-info text-start">
                            <small>Metode Pembayaran:</small><br>
                            <strong><?= $trx['method_name'] ?></strong><br>
                            <hr>
                            <small>Item:</small><br>
                            <strong><?= $trx['item_name'] ?></strong><br>
                            <small>User ID:</small><br>
                            <strong><?= $trx['user_id_game'] ?></strong>
                        </div>

                        <p class="small text-danger">
                            *Ini adalah mode demo. Klik tombol di bawah untuk simulasi pembayaran sukses.*
                        </p>
                        
                        <form action="callback_simulation.php" method="POST">
                            <input type="hidden" name="trx_id" value="<?= $trx['trx_id'] ?>">
                            <button type="submit" class="btn btn-success w-100">Saya Sudah Bayar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>