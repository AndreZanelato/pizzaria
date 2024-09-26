<?php
// Incluir o arquivo de conexão com o banco de dados
require 'db.php';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber os dados do formulário
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $bloco = $_POST['bloco'];
    $apartamento = $_POST['apartamento'];

    // Debug: Exibir os dados recebidos
    echo "Nome: $nome, CPF: $cpf, Bloco: $bloco, Apartamento: $apartamento<br>";

    // Verificar se os campos obrigatórios estão preenchidos
    if (!empty($nome) && !empty($cpf) && !empty($bloco) && !empty($apartamento)) {
        // Conectar ao banco de dados
        $conn = connectDB();

        // Verificar se o CPF já está cadastrado
        $checkCpf = $conn->prepare("SELECT * FROM users WHERE cpf = ?");
        $checkCpf->bind_param("s", $cpf);
        $checkCpf->execute();
        $result = $checkCpf->get_result();

        if ($result->num_rows > 0) {
            // CPF já cadastrado, redirecionar ou exibir mensagem
            echo "CPF já cadastrado. Faça login.";
        } else {
            // Inserir os dados no banco de dados
            $stmt = $conn->prepare("INSERT INTO users (nome, cpf, bloco, apartamento, role) VALUES (?, ?, ?, ?, 'cliente')");
            $stmt->bind_param("ssss", $nome, $cpf, $bloco, $apartamento);

            if ($stmt->execute()) {
                // Redirecionar para a página de login após o cadastro bem-sucedido
                header("Location: login.php");
                exit();
            } else {
                echo "Erro ao cadastrar. Tente novamente.";
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
