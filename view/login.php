<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <style>
        /* ...existing styles... */
        #error-message {
            margin-top: 10px;
            /* Optional: Add additional styling if needed */
        }
        /* ...existing styles... */
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <a href="../index.php"><img src="../img/logo.png" alt="logo" width="70"></a>
        </div>
        <form id="loginForm" method="POST">
            <h2>Login</h2>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Email..." required>
            
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" placeholder="Senha..." required>
            
            <input type="hidden" id="role" name="role" value="user">
            
            <button type="submit">Entrar</button>
            <p id="error-message" style="color: red; display: none;"></p>
            
            <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a></p>
        </form>
    </div>
    <script src="../JS/script.js"></script>
</body>
</html>