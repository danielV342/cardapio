<?php
include "conexao.php";

$sql = "SELECT * FROM pratos";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$pratos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sushi Wabi-Sabi | Cardápio Digital</title>
    <link rel="shortcut icon" href="img/logo-sushi.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #0b0b0b;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
        }
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 80px;
        }
        .navbar {
            background: rgba(0, 0, 0, 0.8) !important;
            backdrop-filter: blur(10px);
        }
        .navbar-nav {
            align-items:center;
        }
        .navbar-brand, h1, h2 {
            font-family: 'Playfair Display', serif;
        }
        .navbar .container {
            position:relative;
        }
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1579871494447-9811cf80d66c?auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
        }
        .img-sushi {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
        .card-sushi {
            background: #1a1a1a;
            border: 1px solid #333;
            transition: transform 0.3s ease;
            height: 100%;
        }
        .card-sushi:hover {
            transform: translateY(-10px);
            border-color: #e63946;
        }
        .btn-order {
            background-color: #e63946;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s;
            margin-top: 10px;
        }
        .btn-order i {
            margin-right: 5px;
        }
        .btn-order:hover {
            background-color: #d4af37;
            transform: scale(1.05);
        }
        .price-tag {
            color: #e63946;
            font-weight: bold;
            font-size: 1.2rem;
        }
        .category-title {
            border-left: 4px solid #e63946;
            padding-left: 15px;
            margin-bottom: 30px;
        }
        .nav-link {
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: #d4af37 !important;
        }
        .nav-link:focus-visible, .btn-order:focus-visible {
            outline: 3px solid #d4af37;
            outline-offset: 2px;
        }
        .nav-icons {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-left: 1rem;
        }
        .nav-icons .text-white {
            transition: color 0.3s ease;
        }
        .nav-icons .text-white:hover {
            color: #d4af37 !important;
        }
        .d-flex.align-items-center.gap-4 {
            position: absolute;
            right: 60px;
            top: 10px;
        }
        .text-secondary {
            color: #b0b0b0 !important;
        }
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #e63946;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .brand-text {
            letter-spacing: 1px;
        }
        .dropdown-menu {
            background-color: #1a1a1a;
            border: 1px solid #333;
        }
        .dropdown-item {
            color: #fff;
        }
        .dropdown-item:hover {
            background-color: #e63946;
            color: #fff;
        }
        @media (max-width: 991px) {
            .navbar-nav {
                align-items: flex-start;
                padding: 1rem 0;
            }
            .nav-icons {
                margin-left: 0;
                padding: 0.5rem 0;
                border-top: 1px solid #333;
                width: 100%;
                justify-content: space-around;
            }
        }
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2.5rem;
            }
            .navbar .container {
                display: flex;
                flex-wrap: wrap;
            }
            .card-sushi img {
                border-radius: 8px;
                width: 100% !important;
                height: 150px !important;
                margin-bottom: 15px;
                margin-left: 0 !important;
            }
            .card-sushi {
                flex-direction: column !important;
                text-align: center;
            }
            .d-flex.align-items-center.gap-4 {
                position: absolute;
                right: 60px;
                top: 10px;
            }
        }
        @media (max-width: 480px) {
            .d-flex.align-items-center.gap-4 {
                right:50px;
            }
            .d-flex.align-items-center.gap-4 span {
                display:none;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-black sticky-top border-bottom border-secondary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#home">
                <img src="img/logo-sushi.png" alt="Logo" width="35" height="35" class="d-inline-block align-middle me-2">
                <span class="brand-text">WABI-SABI</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto text-uppercase" style="font-size: 0.85rem; font-weight: 500;">
                    <li class="nav-item"><a class="nav-link px-3" href="#entradas">Entradas</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#sashimis">Sashimis</a></li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Sushis
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#niguiris">Niguiris</a></li>
                            <li><a class="dropdown-item" href="#rolls">Rolls Especiais</a></li>
                            <li><hr class="dropdown-divider bg-secondary"></li>
                            <li><a class="dropdown-item" href="#wabiSabi">Experiência Wabi-Sabi</a></li>
                        </ul>
                    </li>
                    
                    <li class="nav-item"><a class="nav-link px-3" href="#pratosquentes">Pratos quentes</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#bebidas">Bebidas</a></li>
                </ul>
                
                <div class="nav-icons">
                    <a href="#" class="text-white text-decoration-none d-flex flex-column align-items-center position-relative">
                        <i class="bi bi-cart3 fs-5"></i>
                        <span class="cart-count">0</span>
                        <span style="font-size: 0.7rem;">Carrinho</span>
                    </a>
                    <a href="#" class="text-white text-decoration-none d-flex flex-column align-items-center">
                        <i class="bi bi-person-circle fs-5"></i>
                        <span style="font-size: 0.7rem;">Perfil</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <header class="hero-section" id="home">
        <div class="container">
            <h1 class="display-2">A Arte da Culinária Japonesa</h1>
            <p class="lead">Ingredientes frescos, cortes precisos e sabor inesquecível.</p>
        </div>
    </header>

    <main class="container my-5">
        
 <section id="entradas" class="mb-5">
        <h2 class="category-title">Entradas</h2>
        <div class="row g-4">
            <?php foreach ($pratos as $prato): ?>
                <?php if ($prato['id_categoria'] == 1): ?>
                    <div class="col-md-6">
                        <div class="card card-sushi flex-row align-items-center p-3">
                            <img src="img/<?= $prato['id_prato'] ?>.jpg" style="width: 100px; height: 100px; object-fit: cover;" alt="Shimeji">
                            <div class="ms-3">
                                <h5 class="mb-1"><?= $prato['nome'] ?></h5>
                                <p class="small text-secondary mb-1"><?= $prato['descricao'] ?></p>
                                <span class="price-tag">R$ <?= $prato['preco'] ?></span>
                                <button class="btn-order"><i class="bi bi-plus-circle"></i>Adicionar</button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="sashimis" class="mb-5">
        <h2 class="category-title">Sashimis</h2>
        <div class="row g-4">
            <?php foreach ($pratos as $prato): ?>
                <?php if ($prato['id_categoria'] == 2): ?>
                    <div class="col-md-6">
                        <div class="card card-sushi flex-row align-items-center p-3">
                            <img src="img/<?= $prato['id_prato'] ?>.jpg" style="width: 100px; height: 100px; object-fit: cover;" alt="Shimeji">
                            <div class="ms-3">
                                <h5 class="mb-1"><?= $prato['nome'] ?></h5>
                                <p class="small text-secondary mb-1"><?= $prato['descricao'] ?></p>
                                <span class="price-tag">R$ <?= $prato['preco'] ?></span>
                                <button class="btn-order"><i class="bi bi-plus-circle"></i>Adicionar</button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

     <section id="niguiris" class="mb-5">
        <h2 class="category-title">Sushis e Niguiris</h2>
        <div class="row g-4">
            <?php foreach ($pratos as $prato): ?>
                <?php if ($prato['id_categoria'] == 3): ?>
                    <div class="col-md-6">
                        <div class="card card-sushi flex-row align-items-center p-3">
                            <img src="img/<?= $prato['id_prato'] ?>.jpg" style="width: 100px; height: 100px; object-fit: cover;" alt="Shimeji">
                            <div class="ms-3">
                                <h5 class="mb-1"><?= $prato['nome'] ?></h5>
                                <p class="small text-secondary mb-1"><?= $prato['descricao'] ?></p>
                                <span class="price-tag">R$ <?= $prato['preco'] ?></span>
                                <button class="btn-order"><i class="bi bi-plus-circle"></i>Adicionar</button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="rolls" class="mb-5">
        <h2 class="category-title">Rolls & Especiais</h2>
        <div class="row g-4">
            <?php foreach ($pratos as $prato): ?>
                <?php if ($prato['id_categoria'] == 4): ?>
                    <div class="col-md-6">
                        <div class="card card-sushi flex-row align-items-center p-3">
                            <img src="img/<?= $prato['id_prato'] ?>.jpg" style="width: 100px; height: 100px; object-fit: cover;" alt="Shimeji">
                            <div class="ms-3">
                                <h5 class="mb-1"><?= $prato['nome'] ?></h5>
                                <p class="small text-secondary mb-1"><?= $prato['descricao'] ?></p>
                                <span class="price-tag">R$ <?= $prato['preco'] ?></span>
                                <button class="btn-order"><i class="bi bi-plus-circle"></i>Adicionar</button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="wabiSabi" class="mb-5">
        <h2 class="category-title">Experiência Wabi Sabi</h2>
        <div class="row g-4">
            <?php foreach ($pratos as $prato): ?>
                <?php if ($prato['id_categoria'] == 5): ?>
                    <div class="col-md-6">
                        <div class="card card-sushi flex-row align-items-center p-3">
                            <img src="img/<?= $prato['id_prato'] ?>.jpg" style="width: 100px; height: 100px; object-fit: cover;" alt="Shimeji">
                            <div class="ms-3">
                                <h5 class="mb-1"><?= $prato['nome'] ?></h5>
                                <p class="small text-secondary mb-1"><?= $prato['descricao'] ?></p>
                                <span class="price-tag">R$ <?= $prato['preco'] ?></span>
                                <button class="btn-order"><i class="bi bi-plus-circle"></i>Adicionar</button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="Pratos Quentes" class="mb-5">
        <h2 class="category-title">Pratos Quentes</h2>
        <div class="row g-4">
            <?php foreach ($pratos as $prato): ?>
                <?php if ($prato['id_categoria'] == 6): ?>
                    <div class="col-md-6">
                        <div class="card card-sushi flex-row align-items-center p-3">
                            <img style="border-radius: 50px;" src="img/<?= $prato['id_prato'] ?>.jpg" style="width: 100px; height: 100px; object-fit: cover;" alt="Shimeji">
                            <div class="ms-3">
                                <h5 class="mb-1"><?= $prato['nome'] ?></h5>
                                <p class="small text-secondary mb-1"><?= $prato['descricao'] ?></p>
                                <span class="price-tag">R$ <?= $prato['preco'] ?></span>
                                <button class="btn-order"><i class="bi bi-plus-circle"></i>Adicionar</button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="Bebidas" class="mb-5">
        <h2 class="category-title">Bebidas</h2>
        <div class="row g-4">
            <?php foreach ($pratos as $prato): ?>
                <?php if ($prato['id_categoria'] == 7): ?>
                    <div class="col-md-6">
                        <div class="card card-sushi flex-row align-items-center p-3">
                            <img src="img/<?= $prato['id_prato'] ?>.jpg" style="width: 100px; height: 100px; object-fit: cover;" alt="Shimeji">
                            <div class="ms-3">
                                <h5 class="mb-1"><?= $prato['nome'] ?></h5>
                                <p class="small text-secondary mb-1"><?= $prato['descricao'] ?></p>
                                <span class="price-tag">R$ <?= $prato['preco'] ?></span>
                                <button class="btn-order"><i class="bi bi-plus-circle"></i>Adicionar</button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>




       

    </main>

    <footer class="bg-black text-center py-4 border-top border-secondary">
        <p class="mb-0 text-secondary">&copy; 2026 Sushi WABI-SABI - Qualidade e Tradição.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                if(targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        // Adicione este script
        document.querySelectorAll('.btn-order').forEach(btn => {
            btn.addEventListener('click', function() {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check-lg"></i> Adicionado';
                this.style.backgroundColor = '#28a745';
        
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.style.backgroundColor = '#e63946';
                }, 1500);
            });
        });
    </script>
</body>
</html>