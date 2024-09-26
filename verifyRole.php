<?php
include 'db.php';

$cpf = $_GET['cpf'] ?? '';

$stmt = $pdo->prepare("SELECT role FROM users WHERE cpf = ?");
$stmt->execute([$cpf]);
$user = $stmt->fetch();

if ($user) {
    echo json_encode(['role' => $user['role']]);
} else {
    echo json_encode(['role' => '']);
}
?>
