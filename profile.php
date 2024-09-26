<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $bloco = $_POST['bloco'];
    $apartamento = $_POST['apartamento'];

    // Atualizar o perfil
    $sql = "UPDATE users SET name = ?, bloco = ?, apartamento = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $bloco, $apartamento, $user_id]);

    echo "Perfil atualizado com sucesso!";
}

// Buscar os dados do usuário
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!-- HTML do modal flutuante -->
<form method="post">
    Nome: <input type="text" name="name" value="<?php echo $user['name']; ?>" required><br>
    Bloco: <input type="text" name="bloco" value="<?php echo $user['bloco']; ?>" required><br>
    Apartamento: <input type="text" name="apartamento" value="<?php echo $user['apartamento']; ?>" required><br>
    <button type="submit">Salvar</button>
</form>
