<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - SupraPrime</title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        .top-right {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .top-right a {
            padding: 10px 20px;
            background-color: #ff523b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-left: 10px;
        }
        .top-right a:hover {
            background-color: #e04e30;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="top-right">
            <a href="../view/dashboard.php" class="btn btn-info">Voltar</a>
            <a href="../../backend/api/logout.php" class="btn btn-danger">Sair</a>
        </div>
        <h1>Gerenciar Produtos</h1>
        <form id="formProduto">
            <input type="hidden" id="produtoId">
            <input type="text" id="nome" placeholder="Nome do Produto" required>
            <input type="number" id="preco" placeholder="Preço" required>
            <input type="text" id="imagem" placeholder="URL da Imagem" required>
            <button type="submit">Adicionar Produto</button>
        </form>

        <h2>Produtos</h2>
        <table id="listaProdutos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Produtos serão inseridos aqui -->
            </tbody>
        </table>
    </div>

    <!-- Alert Container -->
    <div id="alertaContainer">
        <!-- Alertas serão inseridos aqui pelo JavaScript -->
    </div>

    <script>
        const formProduto = document.getElementById('formProduto');
        const listaProdutos = document.getElementById('listaProdutos').querySelector('tbody');
        let editMode = false;

        formProduto.addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('produtoId').value.trim();
            const nome = document.getElementById('nome').value.trim();
            const preco = parseFloat(document.getElementById('preco').value);
            const imagem = document.getElementById('imagem').value.trim();

            if (isNaN(preco) || preco <= 0) {
                mostrarAlerta('Por favor, insira um preço válido.', 'danger');
                return;
            }

            const produto = { nome, preco, imagem };

            if (editMode) {
                produto.id = id;
                fetch(`../../backend/api/updateProduct.php`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(produto)
                })
                .then(response => response.json())
                .then(data => {
                    const alerta = obterAlerta();
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
                    const alerta = obterAlerta();
                    alerta.classList.remove('d-none', 'alert-success');
                    alerta.classList.add('alert-danger');
                    alerta.textContent = 'Erro ao atualizar o produto.';
                });
            } else {
                fetch('../../backend/api/createProduct.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(produto)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarAlerta('Produto adicionado com sucesso!', 'success');
                        atualizarListaProdutos();
                        formProduto.reset();
                    } else {
                        mostrarAlerta(data.message || 'Erro ao adicionar produto.', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    mostrarAlerta(`Erro ao adicionar produto: ${error.message}`, 'danger');
                });
            }
        });

        function atualizarListaProdutos() {
            fetch('../../backend/api/getProducts.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(text => {
                    return text ? JSON.parse(text) : {};
                })
                .then(data => {
                    if (data.success) {
                        const listaProdutos = document.getElementById('listaProdutos').querySelector('tbody');
                        listaProdutos.innerHTML = '';
                        data.produtos.forEach(produto => {
                            const preco = parseFloat(produto.preco); // Converte para número
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${produto.id}</td>
                                <td>${produto.nome}</td>
                                <td>R$${preco.toFixed(2)}</td>
                                <td><img src="../${produto.imagem}" alt="${produto.nome}" width="50"></td>
                                <td>
                                    <button onclick="editarProduto(${produto.id}, '${produto.nome}', ${preco}, '${produto.imagem}')">Editar</button>
                                    <button onclick="removerProduto(${produto.id})">Remover</button>
                                </td>
                            `;
                            listaProdutos.appendChild(tr);
                        });
                    } else {
                        mostrarAlerta(data.message || 'Erro ao carregar produtos.', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    mostrarAlerta('Erro ao processar a resposta do servidor.', 'danger');
                });
        }

        function editarProduto(id, nome, preco, imagem) {
            document.getElementById('produtoId').value = id;
            document.getElementById('nome').value = nome;
            document.getElementById('preco').value = preco;
            document.getElementById('imagem').value = imagem;
            document.querySelector('button[type="submit"]').textContent = 'Atualizar Produto';
            editMode = true;
        }

        function removerProduto(id) {
            if (confirm('Tem certeza que deseja deletar este produto?')) {
                fetch(`../../backend/api/deleteProduct.php?id=${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarAlerta('Produto removido com sucesso!', 'success');
                        atualizarListaProdutos();
                    } else {
                        mostrarAlerta('Erro ao remover produto.', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    mostrarAlerta('Erro ao remover produto.', 'danger');
                });
            }
        }

        function mostrarAlerta(mensagem, tipo) {
            const alerta = obterAlerta();
            alerta.className = `alert alert-${tipo}`;
            alerta.textContent = mensagem;
            alerta.classList.remove('d-none');

            setTimeout(() => {
                alerta.classList.add('d-none');
            }, 3000);
        }

        function obterAlerta() {
            let alerta = document.getElementById('alerta');
            if (!alerta) {
                alerta = document.createElement('div');
                alerta.id = 'alerta';
                alerta.className = `alert d-none`;
                alerta.setAttribute('role', 'alert');
                document.getElementById('alertaContainer').appendChild(alerta);
            }
            return alerta;
        }

        // Inicializa a lista de produtos
        atualizarListaProdutos();
    </script>
</body>
</html>
