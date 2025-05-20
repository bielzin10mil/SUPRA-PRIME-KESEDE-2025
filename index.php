<?php
session_start();
include('../backend/api/config.php'); // Inclua o arquivo de configuração para a conexão com o banco de dados

// Função para buscar produtos em promoção (ajuste conforme necessário)
function getPromotionalProducts($conn) {
    $stmt = $conn->prepare("SELECT * FROM produtos LIMIT 6"); // Ajuste a consulta conforme necessário
    $stmt->execute();
    $result = $stmt->get_result();
    $produtos = [];
    while ($row = $result->fetch_assoc()) {
        $produtos[] = $row;
    }
    return $produtos;
}

$produtosPromocao = getPromotionalProducts($conn);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SupraPrime Suplementos</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <script type="text/javascript">
        var isLoggedIn = <?php echo json_encode(isset($_SESSION['user_id'])); ?>;
        console.log("isLoggedIn:", isLoggedIn);
    </script> <!-- Fechar a tag <script> corretamente -->
    <div class="header">
        <div class="navbar">
            <div class="logo">
                <a href="index.php"><img src="img/logo.png" alt="logo" width="70"></a>
            </div>
            <nav>
                <ul id="MenuItems">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="view/produtos.php">Produtos</a></li>
                    <li><a href="view/sobre.php">Sobre</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="view/dashboard.php"><img src="img/profile.png" alt="Perfil" width="30"></a></li>
                        <li><a href="../backend/api/logout.php">Sair</a></li>
                    <?php else: ?>
                        <li class="logincadastro"><a href="view/cadastro.php">Cadastro</a></li>
                        <li class="logincadastro"><a href="view/login.php">Login</a></li>
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

        <!-- Overlay para o carrinho -->
        <div class="overlay" id="overlay" onclick="toggleCart()"></div>

        <!-- Carrinho Sidebar -->
        <div id="cartSidebar" class="cart-sidebar">
            <button class="close-btn" onclick="toggleCart()">&times;</button>
            <h2>Carrinho</h2>
            <div id="cartItems">
                <!-- Itens do carrinho serão renderizados aqui -->
            </div>
            <div class="cart-buttons">
                <button class="btn btn-finalizar" onclick="checkout()">Finalizar Compra</button>
            </div>
        </div>

 <div class="row" style="min-height: 300px; display: flex; justify-content: center; align-items: center;">
  <div class="col-2">
    <div style="padding: 10px; display: flex; justify-content: space-evenly; align-items: center; flex-direction: column; text-align: center; height: 100%;">
      <h1 style="font-size: 2rem; font-weight: 600;">
        Quer deixar de ser um frango? <br>venha para <span style="color: #ff523b;">SupraPrime</span>
      </h1>
      <p style="font-size: 1rem; color: #555; max-width: 400px;">
        Venha e conheça a melhor loja de Suplementos de Campinas e região
      </p>
      <a href="./view/produtos.php" class="btn" style="padding: 0.6rem 1.2rem; font-size: 1rem;">
        Compre Agora →
      </a>
    </div>
  </div>
</div>

            <!-- Hide this div below 768px -->
            <div class="col-7">
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- Produtos -->
    <h2 class="title">Produtos Mais Vendidos</h2>
    <section class="categories">
        <div class="small-container-carousel">
            <div id="categoryCarousel" class="carousel slide" data-ride="carousel" data-interval="2000"
                data-pause="hover">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-12">
                                <img src="img/banner.png" alt="banner1">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-12">
                                <img src="img/banner2.jpg" alt="banner2">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-12">
                                <img src="img/banner3.jpg" alt="banner3">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-12">
                                <img src="img/banner4.jpg" alt="banner4">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-12">
                                <img src="img/banner5.jpg" alt="banner5">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-12">
                                <img src="img/banner6.jpg" alt="banner6">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-12">
                                <img src="img/banner7.jpg" alt="banner7">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-12">
                                <img src="img/banner8.jpg" alt="banner8">
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#categoryCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#categoryCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Produtos -->
    <h2 class="title">Produtos em promoção</h2>
    <div class="small-container">
        <div class="row">
            <?php foreach ($produtosPromocao as $produto): ?>
                <div class="col-4">
                    <img src="<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>">
                    <h4><?php echo $produto['nome']; ?></h4>
                    <div class="rating">
                        <!--avaliação-->
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-o"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                    <p>R$<?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                    <button class="btn add-to-cart" data-product-id="<?php echo $produto['id']; ?>">Adicionar ao Carrinho</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- offerta -->
    <div class="offer">
        <div class="small-container">
            <div class="row">
                <div class="col-2">
                    <img src="img/kit-suplementos2.png" alt="kit-suplementos" class="offer-img">
                </div>
                <div class="col-2">
                    <p>Disponível exclusivamente na SupraPrime</p>
                    <h1>Kit Suplementos</h1>
                    <small> Kit Suplementos com Whey, coqueteleira, barras de proteinas, promoção exclusivamente na
                        Supra.</small><br>
                    <a href="./view/produtos.php" class="btn">Compre agora &#8594;</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Faixa de banner -->
    <div class="faixa-banner">
        <a href="#">
            <img loading="lazy"
                src="https://www.gsuplementos.com.br/upload/banner/d1db8ee5581ce44ec33f05594a057477.webp"
                alt="Whey protein" data-v-fae8387a="">
        </a>
        <div class="banner-content">
            <h2>Whey protein</h2>
            <p>A força que você precisa na construção e na recuperação dos músculos</p>
            <div class="verified-container">
                <p><i class="fa fa-check-circle"></i> Aprovado em todos os laudos de Proteína</p>
                <p><i class="fa fa-check-circle"></i> Compre com confiança</p>
            </div>
        </div>
    </div>

    <!-- Depoimento -->
    <h2 class="title">Depoimentos de Clientes</h2>
    <div class="testimonial">
        <div class="small-container">
            <div class="row">
                <div class="col-3">
                    <i class="fa fa-quote-left"></i>
                    <p>Eu estava procurando por equipamentos de qualidade e acabei encontrando esta loja. A variedade de
                        produtos é incrível e os preços são justos! Comprei pesos e um tapete de yoga, e ambos superaram
                        minhas expectativas. O atendimento foi excepcional; a equipe me ajudou a escolher o que eu
                        realmente precisava. Recomendo a todos que buscam se equipar para os treinos! </p>
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                    <img src="img/01.jpg" alt="Sean">
                    <h3>Lucas Yuji</h3>
                </div>
                <div class="col-3">
                    <i class="fa fa-quote-left"></i>
                    <p>Sou personal trainer e sempre recomendo essa loja para meus alunos. A qualidade dos suprimentos é
                        imbatível e a seleção é perfeita para quem quer montar um home gym. Fiz várias compras, desde
                        faixas elásticas até acessórios de pilates, e todos os produtos chegaram super rápido. Além
                        disso, adoro a atenção ao cliente; sempre têm dicas valiosas para otimizar os treinos!</p>
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                    <img src="img/02.jpg" alt="Mike">
                    <h3>Gustavo Pascoal</h3>
                </div>
                <div class="col-3">
                    <i class="fa fa-quote-left"></i>
                    <p>Descobri essa loja recentemente e estou encantada! Comprei alguns suplementos e acessórios e
                        percebi uma grande diferença nos meus treinos. A entrega foi rápida e o suporte online é muito
                        bom, ajudaram-me a escolher o que combinava com meus objetivos. Com certeza, é meu novo lugar
                        favorito para tudo relacionado a fitness! </p>
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                    <img src="img/03.jpg" alt="Mabel">
                    <h3>Larissa Manoela</h3>
                </div>
            </div>
        </div>
    </div>


    <!-- footer -->

    <div class="footer">
        <div class="container">
            <hr>
            <p class="copyright">Copyright 2024 - SupraPrime</p>
        </div>
    </div>

    <!-- Campo de script.js antes de fechar o body -->
    <script src="JS/script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            verificarAutenticacao(); // Chama a função correta para atualizar os botões do menu
            atualizarCarrinho(); // Atualiza o carrinho ao carregar a página
        });
    </script>
</body>
</html>