<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = $_POST['cpf'];

    // Conectar ao banco de dados
    $conn = connectDB();

    // Verificar se o CPF existe e buscar os pontos do usuário
    $stmt = $conn->prepare("SELECT id, user_name, points FROM users WHERE cpf = ?");
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Guardar os dados na sessão
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['pontos'] = $user['points']; // Guardar os pontos na sessão

        // Redirecionar para a página inicial
        header("Location: index.php");
        exit();
    } else {
        echo "CPF não encontrado. Verifique os dados ou cadastre-se.";
    }

    $stmt->close();
    $conn->close();
}
?>
