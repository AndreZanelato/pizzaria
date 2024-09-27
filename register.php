<?php
// Incluir o arquivo de conexão com o banco de dados
require 'db.php';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber os dados do formulário
    $nome = trim($_POST['user_name']);
    $cpf = trim($_POST['cpf']);
    $bloco = trim($_POST['bloco']);
    $apartamento = trim($_POST['apartamento']);

    // Debug: Exibir os dados recebidos
    echo "Nome: $nome, CPF: $cpf, Bloco: $bloco, Apartamento: $apartamento<br>";

    // Verificar se todos os campos foram preenchidos
    if (!empty($nome) && !empty($cpf) && !empty($bloco) && !empty($apartamento)) {
        // Conectar ao banco de dados
        $conn = connectDB();

        // Verificar se o CPF já está cadastrado
        $checkCpf = $conn->prepare("SELECT * FROM users WHERE cpf = ?");
        if (!$checkCpf) {
            die("Erro na preparação da consulta SELECT: " . $conn->error);
        }
        $checkCpf->bind_param("s", $cpf);
        $checkCpf->execute();
        $result = $checkCpf->get_result();

        if ($result->num_rows > 0) {
            echo "CPF já cadastrado. Faça login.";
        } else {
            // Inserir os dados no banco de dados
            $stmt = $conn->prepare("INSERT INTO users (user_name, cpf, bloco, apartamento, role) VALUES (?, ?, ?, ?, 'cliente')");

            if (!$stmt) {
                die("Erro na preparação da consulta INSERT: " . $conn->error);
            }

            $stmt->bind_param("ssss", $nome, $cpf, $bloco, $apartamento);

            if ($stmt->execute()) {
                // Redirecionar para a página inicial após o cadastro bem-sucedido
                header("Location: index.php");
                exit(); // Pare o script aqui para garantir que não continue a execução
            } else {
                // Exibir erro detalhado
                echo "Erro ao cadastrar: " . $stmt->error;
            }

            // Fechar a declaração
            $stmt->close();
        }

        // Fechar a conexão com o banco
        closeDB($conn);
    } else {
        echo "Por favor, preencha todos os campos.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>
