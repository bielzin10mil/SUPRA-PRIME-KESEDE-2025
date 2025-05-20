<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php'); // Redireciona para a página de login se não for administrador
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Usuários</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .user-management-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .user-management-table th, .user-management-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .user-management-table th {
            background-color: #f2f2f2;
            color: #333;
        }
        .user-management-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .user-management-table tr:hover {
            background-color: #f1f1f1;
        }
        .user-management-table button {
            padding: 5px 10px;
            border: none;
            background-color: #ff523b;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
        .user-management-table button:hover {
            background-color: #e04e30;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .modal form {
            display: flex;
            flex-direction: column;
        }
        .modal form label {
            margin: 10px 0 5px;
        }
        .modal form input, .modal form select {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .modal form button {
            padding: 10px;
            border: none;
            background-color: #ff523b;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
        .modal form button:hover {
            background-color: #e04e30;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gerenciar Usuários</h1>
        <button onclick="window.history.back();" style="float: right; margin-bottom: 20px; padding: 10px 20px; background-color: #ff523b; color: white; border: none; border-radius: 5px; cursor: pointer;">Voltar</button>
        <table class="user-management-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Função</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../../backend/api/config.php'; // Corrected path

                // Update the column names to match your database schema
                $sql = "SELECT id, nome, email, role FROM users"; // Corrected column name to 'nome'
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['nome']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['role']}</td>
                                <td>
                                    <button onclick=\"editarUsuario({$row['id']})\">Editar</button>
                                    <button onclick=\"excluirUsuario({$row['id']})\">Excluir</button>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum usuário encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Modal de Edição de Usuário -->
        <div id="editUserModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('editUserModal').style.display='none'">&times;</span>
                <h2>Editar Usuário</h2>
                <form id="editUserForm">
                    <input type="hidden" id="editUserId" name="id">
                    <label for="editUserName">Nome:</label>
                    <input type="text" id="editUserName" name="nome" required> <!-- Corrected column name to 'nome' -->
                    <label for="editUserEmail">Email:</label>
                    <input type="email" id="editUserEmail" name="email" required>
                    <label for="editUserRole">Função:</label>
                    <select id="editUserRole" name="role" required>
                        <option value="admin">Admin</option>
                        <option value="user">Usuário</option>
                    </select>
                    <button type="submit">Salvar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="../JS/script.js"></script>
    <script>
        function excluirUsuario(userId) {
            console.log(`Tentando excluir usuário com ID: ${userId}`);
            if (confirm('Tem certeza que deseja excluir este usuário?')) {
                fetch(`../../backend/api/delete_user.php`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${userId}`
                })
                .then(response => {
                    console.log('Resposta do servidor:', response);
                    return response.text(); // Alterado para text() para depuração
                })
                .then(text => {
                    console.log('Texto recebido do servidor:', text);
                    try {
                        const data = JSON.parse(text);
                        console.log('Dados recebidos do servidor:', data);
                        if (data.success) {
                            alert('Usuário excluído com sucesso.');
                            location.reload();
                        } else {
                            alert('Erro ao excluir usuário.');
                        }
                    } catch (error) {
                        console.error('Erro ao analisar JSON:', error);
                        console.error('Resposta do servidor:', text);
                        alert('Erro ao excluir usuário.');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao excluir usuário.');
                });
            }
        }
    </script>
</body>
</html>