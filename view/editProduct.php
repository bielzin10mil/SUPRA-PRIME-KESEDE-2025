<?php

// Start output buffering
ob_start();

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Definir o caminho absoluto para o arquivo config.php
$configPath = __DIR__ . '/../backend/api/config.php';

// Verifica se o arquivo de configuração existe
if (!file_exists($configPath)) {
    // Log the error
    error_log("Arquivo de configuração não encontrado: {$configPath}");
    // Return JSON error response
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Arquivo de configuração não encontrado.']);
    ob_end_clean();
    exit();
}

// Inclui o arquivo de configuração
include($configPath);

// Verifica se a conexão com o banco de dados foi estabelecida
if (!isset($conn)) {
    error_log("Conexão com o banco de dados não está definida.");
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Conexão com o banco de dados não está definida.']);
    ob_end_clean();
    exit();
}

// Verifica se o ID do produto foi fornecido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepara a consulta para buscar o produto pelo ID
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
    if (!$stmt) {
        error_log("Erro na preparação da consulta: " . $conn->error);
        echo "Erro interno do servidor.";
        ob_end_clean();
        exit();
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o produto existe
    if ($result->num_rows === 1) {
        $produto = $result->fetch_assoc();
    } else {
        echo "Produto não encontrado.";
        ob_end_clean();
        exit();
    }

    $stmt->close();
} else {
    echo "ID de produto inválido.";
    ob_end_clean();
    exit();
}

$conn->close();

// Clean (erase) the output buffer and turn off output buffering
ob_end_clean();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto - SupraPrime</title>
    <link rel="stylesheet" href="../css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .top-right {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <a href="productManagement.php" class="btn btn-info top-right">Voltar</a>
        <h2 class="mb-4">Editar Produto</h2>

        <!-- Área de Alertas -->
        <div id="alerta" class="alert d-none" role="alert"></div>

        <form id="editProductForm">
            <input type="hidden" id="productId" value="<?php echo htmlspecialchars($produto['id']); ?>">
            <div class="form-group">
                <label for="nome">Nome do Produto</label>
                <input type="text" class="form-control" id="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>
            </div>
            <div class="form-group">
                <label for="preco">Preço</label>
                <input type="number" step="0.01" class="form-control" id="preco" value="<?php echo htmlspecialchars($produto['preco']); ?>" required>
            </div>
            <div class="form-group">
                <label for="imagem">URL da Imagem</label>
                <input type="text" class="form-control" id="imagem" value="<?php echo htmlspecialchars($produto['imagem']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar Produto</button>
            <a href="admin.php" class="btn btn-secondary">Cancelar</a>
            <a href="logout.php" class="btn btn-danger">Sair</a>
        </form>
    </div>

    <!-- Bootstrap JS e Dependências -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Script Personalizado -->
    <script>
        document.getElementById('editProductForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const id = document.getElementById('productId').value;
            const nome = document.getElementById('nome').value.trim();
            const preco = parseFloat(document.getElementById('preco').value);
            const imagem = document.getElementById('imagem').value.trim();

            if (isNaN(preco) || preco <= 0) {
                mostrarAlerta('Por favor, insira um preço válido.', 'danger');
                return;
            }

            const dados = { id, nome, preco, imagem };

            fetch('../backend/api/updateProduct.php', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dados)
            })
                .then(response => response.json())
                .then(data => {
                    const alerta = document.getElementById('alerta');
                    if(data.success){
                        alerta.classList.remove('d-none', 'alert-danger');
                        alerta.classList.add('alert-success');
                        alerta.textContent = data.message;

                        // Redireciona após 2 segundos
                        setTimeout(() => {
                            window.location.href = 'admin.php';
                        }, 2000);
                    } else {
                        alerta.classList.remove('d-none', 'alert-success');
                        alerta.classList.add('alert-danger');
                        alerta.textContent = data.message;
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    const alerta = document.getElementById('alerta');
                    alerta.classList.remove('d-none', 'alert-success');
                    alerta.classList.add('alert-danger');
                    alerta.textContent = 'Erro ao atualizar o produto.';
                });
        });

        function mostrarAlerta(mensagem, tipo) {
            const alerta = document.getElementById('alerta');
            alerta.className = `alert alert-${tipo}`;
            alerta.textContent = mensagem;
            alerta.classList.remove('d-none');

            setTimeout(() => {
                alerta.classList.add('d-none');
            }, 3000);
        }
    </script>
</body>
</html>