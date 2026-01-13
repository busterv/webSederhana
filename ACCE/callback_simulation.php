<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trx_id = $_POST['trx_id'];

    $stmt = $pdo->prepare("UPDATE transactions SET status = 'success' WHERE trx_id = ?");
    $stmt->execute([$trx_id]);

    echo "<script>
        alert('Pembayaran Berhasil Dikonfirmasi!');
        window.location.href = 'cek_transaksi.php?search=' + '$trx_id';
    </script>";
}
?>