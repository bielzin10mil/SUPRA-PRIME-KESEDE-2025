
<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include('../../backend/api/config.php');

// Buscar registros de clientes
$result = $conn->query("SELECT rc.id, u.nome AS cliente, p.nome AS produto, rc.quantidade, rc.data_compra 
                        FROM registros_clientes rc 
                        JOIN users u ON rc.user_id = u.id 
                        JOIN produtos p ON rc.produto_id = p.id");

$registros = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $registros[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Histórico de Compras</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Histórico de Compras</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Data da Compra</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $registro): ?>
                    <tr>
                        <td><?php echo $registro['id']; ?></td>
                        <td><?php echo $registro['cliente']; ?></td>
                        <td><?php echo $registro['produto']; ?></td>
                        <td><?php echo $registro['quantidade']; ?></td>
                        <td><?php echo $registro['data_compra']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="dashboard.php">Voltar ao Dashboard</a>
    </div>
</body>
</html>