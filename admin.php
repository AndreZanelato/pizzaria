<?php
session_start();
include 'db.php';

if ($_SESSION['role'] != 'administrador') {
    header('Location: index.php');
    exit;
}

// Listar pedidos pendentes
$stmt = $pdo->query("SELECT * FROM orders WHERE status = 'pendente'");
$orders = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $total = $_POST['total'];

    // Atualizar status do pedido
    $stmt = $pdo->prepare("UPDATE orders SET status = 'concluído' WHERE id = ?");
    $stmt->execute([$order_id]);

    // Calcular pontos (1 ponto a cada 50 reais)
    $points = floor($total / 50);
    $user_id = $_POST['user_id'];

    // Atualizar pontos do cliente
    $stmt = $pdo->prepare("UPDATE points SET points = points + ? WHERE user_id = ?");
    $stmt->execute([$points, $user_id]);

    echo "Pedido finalizado e pontos atribuídos!";
}
?>

<!-- Listar pedidos -->
<?php foreach ($orders as $order): ?>
    <form method="post">
        Pedido de: <?php echo $order['user_id']; ?> - Total: R$ <?php echo $order['total']; ?><br>
        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
        <input type="hidden" name="user_id" value="<?php echo $order['user_id']; ?>">
        <input type="hidden" name="total" value="<?php echo $order['total']; ?>">
        <button type="submit">Finalizar pedido</button>
    </form>
<?php endforeach; ?>
