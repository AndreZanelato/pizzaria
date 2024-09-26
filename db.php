<?php
// Definir as constantes do banco de dados
define('DB_HOST', 'localhost');   // Host do banco de dados
define('DB_USER', 'pizzafir_admin');        // Usuário do banco de dados
define('DB_PASS', '@Ndrezanelat0123');            // Senha do banco de dados
define('DB_NAME', 'pizzafir_db');    // Nome do banco de dados

// Função para conectar ao banco de dados
function connectDB() {
    // Cria a conexão usando mysqli
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Verifica se houve erro na conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Definir o charset como utf8 para garantir compatibilidade com acentos
    $conn->set_charset("utf8");

    return $conn; // Retorna a conexão
}

// Função para fechar a conexão com o banco de dados
function closeDB($conn) {
    $conn->close();
}
