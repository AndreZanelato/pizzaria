<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Pizza de Firenze</title>

    <link rel="shortcut icon" type="imagex/png" href="img/icon.ico">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
</head>

<body>

    <div class="header">
        <a href="."><img src="img/logo.png" alt="Mini Pizza de Firenze"></a>
        <nav class="submenu">
            <a href=".">Menu</a>
            <a href="/perfil">Perfil</a>

            <!-- Exibir saudação e pontos -->
            <?php if (isset($_SESSION['user_name'])): ?>
                <span>Olá, <?php echo $_SESSION['user_name']; ?>! Você possui <?php echo $_SESSION['pontos']; ?> pontos.</span>
            <?php else: ?>
                <a href="#" onclick="openLoginModal()">Login</a>
            <?php endif; ?>
        </nav>
    </div>

    <div class="product-list">
        <!-- Os produtos serão gerados dinamicamente aqui -->
    </div>

    <!-- Botão do carrinho -->
    <button class="cart-btn" onclick="toggleCartMenu()">🛒 Carrinho (<span id="cart-count">0</span>)</button>

    <!-- Menu lateral do carrinho -->
    <div class="cart-sidebar">
        <div class="cart-header">
            <h2>Seu Carrinho</h2>
            <button class="close-btn" onclick="toggleCartMenu()">✖</button>
        </div>
        <div class="cart-items"></div>
        <div class="cart-footer">
            <label for="bloco-apartamento">Bloco e Apartamento:</label>
            <input type="text" id="bloco-apartamento" placeholder="Bloco x Apto x">

            <p>Total: <span id="total-price">R$ 0,00</span></p>
            <label for="payment-method">Forma de Pagamento:</label>
            <select id="payment-method">
                <option value="Dinheiro">Dinheiro</option>
                <option value="PIX">PIX</option>
                <option value="Cartão de Crédito">Cartão de Crédito</option>
                <option value="Cartão de Débito">Cartão de Débito</option>
            </select>
            <button onclick="proceedToWhatsApp()">Finalizar Compra</button>
        </div>
    </div>

    <!-- Modal de Login -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeLoginModal()">&times;</span>
            <h2>Login</h2>
            <form method="post" action="login.php">
                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" id="cpfField" required><br>

                <!-- Campo de senha, aparece apenas se CPF for "pizzafir_admin" -->
                <div id="passwordField" style="display: none;">
                    <label for="password">Senha:</label>
                    <input type="password" name="password"><br>
                </div>

                <button type="submit">Entrar</button>
            </form>
            <!-- Link para cadastro -->
            <p>
                Caso ainda não tenha uma conta,
                <a href="#" onclick="openSignupModal(); closeLoginModal()">cadastre-se aqui!</a>
            </p>
        </div>
    </div>

    <!-- Modal de Cadastro -->
    <div id="signupModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeSignupModal()">&times;</span>
            <h2>Cadastro</h2>
            <form method="post" action="register.php">
                <label for="nome">Nome:</label>
                <input type="text" name="user_name" required><br>

                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" required><br>

                <label for="bloco">Bloco:</label>
                <input type="text" name="bloco" required><br>

                <label for="apartamento">Apartamento:</label>
                <input type="text" name="apartamento" required><br>

                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </div>

    <script src="products.js"></script>
    <script src="script.js"></script>

</body>

</html>
