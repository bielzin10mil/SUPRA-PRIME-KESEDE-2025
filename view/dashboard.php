<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redireciona para a página de login se não estiver logado
    exit();
}

$user_name = htmlspecialchars($_SESSION['user_name']);
$isAdmin = $_SESSION['user_role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <div class="dashboard-container">
        <h1>Bem-vindo, <?php echo $user_name; ?>!</h1>
        <p>Este é o seu painel de controle.</p>
        <?php if ($isAdmin): ?>
            <a href="admin.php">Gerenciar Produtos</a>
            <a href="user_management.php">Gerenciar Usuários</a>
            <a href="registro_clientes.php">Histórico de Compras</a>
        <?php endif; ?>
        <a href="../../backend/api/logout.php">Sair</a>
        <?php if (!$isAdmin): ?>
            <a href="../index.php">Página Inicial</a>
        <?php endif; ?>
    </div>
</body>

</html>