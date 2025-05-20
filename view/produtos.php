<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<script type="text/javascript">
    var isLoggedIn = <?php echo json_encode(isset($_SESSION['user_id'])); ?>;
</script> <!-- Fechar a tag <script> corretamente -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="shortcut icon" href="../img/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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

    <div class="small-container">
        <div class="row row-2">
            <h2>Todos os Produtos</h2>
        </div>

        <div class="row" id="product-list">
            <!-- Produtos serão renderizados aqui -->
        </div>

        <div class="page-btn">
            <span>1</span>
            <span><a href="produtos2.php">2</a></span>
            <span>&#8594;</span>
        </div>
    </div>

    <!-- Carrinho Sidebar e Overlay -->
    <div class="overlay" id="overlay" onclick="toggleCart()"></div>

    <div id="cartSidebar" class="cart-sidebar">
        <button class="close-btn" onclick="toggleCart()">&times;</button>
        <h2>Carrinho</h2>
        <div id="cartItems">
            <!-- Itens do carrinho serão renderizados aqui -->
        </div>
        <button onclick="checkout()">Finalizar Compra</button>
    </div>

    <!-- footer -->
    <div class="footer">
        <div class="container">
            <hr>
            <p class="copyright">Copyright 2024 - SupraPrime</p>
        </div>
    </div>

    <script src="../JS/script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            verificarAutenticacao(); // Atualiza os botões do menu
            atualizarCarrinho(); // Atualiza o carrinho ao carregar a página

            // Buscar e renderizar produtos
            fetch('../../backend/api/getAllProducts.php?start_id=7&end_id=15')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const productList = document.getElementById('product-list');
                        data.produtos.forEach(produto => {
                            const productDiv = document.createElement('div');
                            productDiv.className = 'col-4';
                            productDiv.innerHTML = `
                                <img src="../${produto.imagem}" alt="${produto.nome}">
                                <h4>${produto.nome}</h4>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <p>${produto.preco > 0 ? `R$${produto.preco}` : 'Indisponível'}</p>
                                ${produto.id > 0 ? `<button class="btn add-to-cart" data-product-id="${produto.id}">Adicionar ao Carrinho</button>` : ''}
                            `;
                            productList.appendChild(productDiv);
                        });

                        // Adicionar event listeners aos botões de adicionar ao carrinho
                        document.querySelectorAll('.add-to-cart').forEach(button => {
                            button.addEventListener('click', function () {
                                const productId = this.getAttribute('data-product-id');
                                adicionarAoCarrinho(productId);
                            });
                        });
                    } else {
                        console.error('Erro ao carregar produtos:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro ao carregar produtos:', error);
                });
        });
    </script>
</body>

</html>