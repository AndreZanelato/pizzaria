<?php
// Conexão ao banco de dados
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $cpf = $_POST['cpf'];
    $bloco = $_POST['bloco'];
    $apartamento = $_POST['apartamento'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Inserir o novo usuário
    $sql = "INSERT INTO users (name, cpf, bloco, apartamento, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $cpf, $bloco, $apartamento, $password]);

    echo "Cadastro realizado com sucesso!";
}
?>
