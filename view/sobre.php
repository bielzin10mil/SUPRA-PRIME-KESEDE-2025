<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre</title>
    <link rel="shortcut icon" href="../img/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sobre.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <script type="text/javascript">
        var isLoggedIn = <?php echo json_encode(isset($_SESSION['user_id'])); ?>;
    </script>
</head>

<body>
    <div class="header">
        <div class="navbar">
            <div class="logo">
                <a href="../index.php"><img src="../img/logo.png" alt="logo" width="70"></a>
            </div>
            <nav>
                <ul id="MenuItems">
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="produtos.php">Produtos</a></li>
                    <li><a href="sobre.php">Sobre</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="dashboard.php"><img src="../img/profile.png" alt="Perfil" width="30"></a></li>
                        <li><a href="../backend/api/logout.php">Sair</a></li>
                    <?php else: ?>
                        <li class="logincadastro"><a href="cadastro.php">Cadastro</a></li>
                        <li class="logincadastro"><a href="login.php">Login</a></li>
                    <?php endif; ?>
                    <!-- Botão de Carrinho -->
                    <li>
                        <a href="#" onclick="toggleCart()">
                            <i class="fa fa-shopping-cart"></i>
                            <span id="cart-count">0</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="menu-icon">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <h1>Sobre a SupraPrime</h1>
        <p>Bem-vindo à SupraPrime, sua loja de suplementos de confiança. Fundada em 2024, nossa missão é fornecer
            produtos de alta qualidade para ajudar você a alcançar seus objetivos de saúde e fitness.</p>
        <h2>Nossa Missão</h2>
        <p>Na SupraPrime, acreditamos que a saúde e o bem-estar são fundamentais para uma vida plena. Nosso objetivo é
            oferecer suplementos que atendam às necessidades de todos, desde atletas profissionais até entusiastas do
            fitness.</p>
        <h2>Nossos Valores</h2>
        <ul>
            <li><strong>Qualidade:</strong> Produtos de alta qualidade, testados e aprovados.</li>
            <li><strong>Confiança:</strong> Transparência e honestidade em todas as nossas ações.</li>
            <li><strong>Inovação:</strong> Sempre buscando as melhores soluções para nossos clientes.</li>
            <li><strong>Comunidade:</strong> Apoio e incentivo à comunidade fitness.</li>
        </ul>
        <h2>Equipe</h2>
        <div class="our_team">
            <div class="team_member">
                <div class="member_img">
                    <img src="../img/foto.png" alt="our_team">
                </div>
                <h3>Gabriel Rocha</h3>
                <p><b>RA:202302704328</b></p>
            </div>
            <div class="team_member">
                <div class="member_img">
                    <img src="../img/foto.png" alt="our_team">
                </div>
                <h3>Gabriel Silveira</h3>
                <p><b>RA:202302381911</b></p>
            </div>
                <div class="team_member">
                <div class="member_img">
                    <img src="../img/foto.png" alt="our_team">
                </div>
                <h3>Caio Tawfiq</h3>
                <p><b>RA:202408292007</b></p>
            </div>
            <div class="team_member">
                <div class="member_img">
                    <img src="../img/foto.png" alt="our_team">
                </div>
                <h3>Gustavo Pascoal</h3>
                <p><b>RA:202302380931</b></p>
            </div>
        </div>
    </div>

    <!-- footer -->
    <div class="footer">
        <div class="container">
            <div class="social-icons">
                <a href="https://www.instagram.com" target="_blank"><i class="fa fa-instagram"></i></a>
                <a href="https://www.twitter.com" target="_blank"><i class="fa fa-twitter"></i></a>
                <a href="https://www.whatsapp.com" target="_blank"><i class="fa fa-whatsapp"></i></a>
            </div>
            <hr>
            <p class="copyright">Copyright 2024 - SupraPrime</p>
        </div>
    </div>

    <script>
        var menuItems = document.getElementById("MenuItems");
        MenuItems.style.maxHeight = "0px";
        function menutoggle() {
            if (MenuItems.style.maxHeight == "0px") {
                MenuItems.style.maxHeight = "200px";
            }
            else {
                MenuItems.style.maxHeight = "0px";
            }
        }
    </script>
    <script src="../JS/script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            verificarAutenticacao(); // Atualiza os botões do menu
        });
    </script>
</body>

</html>