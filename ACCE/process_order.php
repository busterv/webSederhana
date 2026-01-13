<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$game_id = filter_input(INPUT_POST, 'game_id', FILTER_VALIDATE_INT);
$product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$payment_id = filter_input(INPUT_POST, 'payment_id', FILTER_VALIDATE_INT);
$user_id_game = trim(htmlspecialchars($_POST['user_id']));
$phone = trim(htmlspecialchars($_POST['phone']));

if (!$game_id || !$product_id || !$payment_id || empty($user_id_game)) {
    die("Error: Data tidak lengkap atau tidak valid.");
}

try {
    $stmtProd = $pdo->prepare("SELECT price, item_name FROM products WHERE id = ?");
    $stmtProd->execute([$product_id]);
    $product = $stmtProd->fetch();

    $stmtPay = $pdo->prepare("SELECT admin_fee, name, code FROM payment_methods WHERE id = ?");
    $stmtPay->execute([$payment_id]);
    $payment = $stmtPay->fetch();

    if (!$product || !$payment) {
        throw new Exception("Produk atau metode pembayaran tidak valid.");
    }

    $total_amount = $product['price'] + $payment['admin_fee'];
    $trx_id = generateTrxId();

    $stmtInsert = $pdo->prepare("
        INSERT INTO transactions (trx_id, user_id_game, game_id, product_id, payment_method_id, total_amount, phone_number, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')
    ");
    
    $stmtInsert->execute([
        $trx_id, $user_id_game, $game_id, $product_id, $payment_id, $total_amount, $phone
    ]);

    header("Location: payment.php?trx_id=" . $trx_id);
    exit;

} catch (Exception $e) {
    die("Terjadi Kesalahan: " . $e->getMessage());
}
?>