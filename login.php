<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $password = $_POST['password'] ?? null;

    // Buscar o usuário pelo CPF
    $stmt = $pdo->prepare("SELECT * FROM users WHERE cpf = ?");
    $stmt->execute([$cpf]);
    $user = $stmt->fetch();

    if ($user) {
        if ($cpf === 'pizzafir_admin') {
            // Verifica a senha apenas para o administrador
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                header('Location: admin.php');
            } else {
                echo "Senha incorreta!";
            }
        } else {
            // Login para clientes apenas com o CPF
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header('Location: index.php');
        }
    } else {
        echo "Usuário não encontrado!";
    }
}
?>
