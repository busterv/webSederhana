<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Cek Pesanan - AceGame</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #e3f2fd;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="text-center text-primary mb-4">Lacak Pesanan AceGame</h3>
                        <form action="" method="GET" class="d-flex gap-2 mb-4">
                            <input type="text" name="search" class="form-control" placeholder="Masukkan Nomor Transaksi (ACE-XXX)" value="<?= $_GET['search'] ?? '' ?>">
                            <button class="btn btn-primary">Cari</button>
                        </form>

                        <?php
                        if (isset($_GET['search'])) {
                            $search = $_GET['search'];
                            $stmt = $pdo->prepare("
                                SELECT t.*, g.name as game_name, p.item_name 
                                FROM transactions t
                                JOIN games g ON t.game_id = g.id
                                JOIN products p ON t.product_id = p.id
                                WHERE t.trx_id = ?
                            ");
                            $stmt->execute([$search]);
                            $data = $stmt->fetch();

                            if ($data) {
                                $badge = $data['status'] == 'success' ? 'bg-success' : 'bg-warning';
                                echo "
                                <div class='alert alert-light border'>
                                    <h5>ID: {$data['trx_id']} <span class='badge $badge float-end'>".strtoupper($data['status'])."</span></h5>
                                    <hr>
                                    <p>Game: <strong>{$data['game_name']}</strong></p>
                                    <p>Item: {$data['item_name']}</p>
                                    <p>Total: Rp ".number_format($data['total_amount'],0,',','.')."</p>
                                    <p class='small text-muted'>Dibuat: {$data['created_at']}</p>
                                </div>";
                            } else {
                                echo "<div class='alert alert-danger'>Transaksi tidak ditemukan.</div>";
                            }
                        }
                        ?>
                        <div class="text-center mt-3">
                            <a href="index.php">Kembali ke Beranda</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>