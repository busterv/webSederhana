<?php
$host = 'localhost';
$db   = 'acegame_db';
$user = 'saghex';
$pass = 'saghex123456789101112';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi Gagal: " . $e->getMessage());
}

function generateTrxId() {
    return 'ACCE-' . strtoupper(bin2hex(random_bytes(3)));
}
?>