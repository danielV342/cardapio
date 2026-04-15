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
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">
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
            align-items: center;
        }

        .navbar-brand,
        h1,
        h2 {
            font-family: 'Playfair Display', serif;
        }

        .navbar .container {
            position: relative;
        }

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1579871494447-9811cf80d66c?auto=format&fit=crop&w=1350&q=80');
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
            border: 1px solid #696969;
            transition: transform 0.3s ease;
            height: 100%;
        }

        .card-sushi h5 {
            color: #fff;
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

        .nav-link:focus-visible,
        .btn-order:focus-visible {
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
            color: #525050 !important;
        }

        .cart-count {
            position: absolute;
            top: -4px;
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

        .modal-title {
            color: #333;
        }

        .cart-modal .modal-content {
            background-color: #1a1a1a;
            border: 1px solid #333;
            color: #fff;
        }

        .cart-item {
            border-bottom: 1px solid #333;
            color: #e63946;
            padding: 10px 0;
        }
        
        .cart-item h6 {
            color: #1a1a1a;
        }

        .cart-item strong {
            color: #d4af37;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-total {
            font-size: 1.2rem;
            font-weight: bold;
            color: #e63946;
            border-top: 2px solid #333;
            padding-top: 15px;
            margin-top: 15px;
        }

        .payment-method {
            margin: 15px 0;
            padding: 10px;
            border: 1px solid #333;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .payment-method:hover {
            border-color: #e63946;
            background-color: rgba(230, 57, 70, 0.1);
        }

        .payment-method.selected {
            border-color: #e63946;
            background-color: rgba(230, 57, 70, 0.2);
        }

        .btn-clear-cart {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
        }

        .btn-checkout {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
        }

        .modal-body {
            color: #1a1a1a;
        }

        .text-secondary.d-block {
            color: #7a4e4e !important;
        }

        .cart-empty {
            text-align: center;
            padding: 40px;
            color: #b0b0b0;
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
                right: 50px;
            }

            .d-flex.align-items-center.gap-4 span {
                display: none;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-black sticky-top border-bottom border-secondary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#home">
                <img src="img/logo-sushi.png" alt="Logo" width="35" height="35"
                    class="d-inline-block align-middle me-2">
                <span class="brand-text">WABI-SABI</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto text-uppercase" style="font-size: 0.85rem; font-weight: 500;">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Entradas
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#entradas">Entradas</a></li>
                            <li><a class="dropdown-item" href="#sushis">Sushis Tradicionais</a></li>
                            <li><a class="dropdown-item" href="#hossomaki">Hossomaki</a></li>
                            <li><a class="dropdown-item" href="#uramaki">Uramaki</a></li>
                            <li><a class="dropdown-item" href="#sashimis">Sashimis</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link px-3" href="#temakis">Temakis</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#hotrolls">Hot Rolls</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#renomados">Pratos Renomados</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#supremo">Supremos</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Bebidas</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#bebida">Sem Álcool</a></li>
                            <li><a class="dropdown-item" href="#alcoolicas">Alcoólicas</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link px-3" href="#combo">Combos</a></li>
                </ul>

                <div class="nav-icons">
                    <a href="#"
                        class="text-white text-decoration-none d-flex flex-column align-items-center position-relative">
                        <i class="bi bi-cart3 fs-5"></i>
                        <span class="cart-count">0</span>
                        <span style="font-size: 0.7rem;">Carrinho</span>
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
                                <img src="img/<?= $prato['id_prato'] ?>.jpg"
                                    style="width: 100px; height: 100px; object-fit: cover;" alt="Entradas">
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

        <section id="sushis" class="mb-5">
            <h2 class="category-title">Sushis Tradicionais</h2>
            <div class="row g-4">
                <?php foreach ($pratos as $prato): ?>
                    <?php if ($prato['id_categoria'] == 2): ?>
                        <div class="col-md-6">
                            <div class="card card-sushi flex-row align-items-center p-3">
                                <img src="img/<?= $prato['id_prato'] ?>.jpg"
                                    style="width: 100px; height: 100px; object-fit: cover;" alt="Sushi Tradicional">
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

        <section id="hossomaki" class="mb-5">
            <h2 class="category-title">Hossomaki</h2>
            <div class="row g-4">
                <?php foreach ($pratos as $prato): ?>
                    <?php if ($prato['id_categoria'] == 3): ?>
                        <div class="col-md-6">
                            <div class="card card-sushi flex-row align-items-center p-3">
                                <img src="img/<?= $prato['id_prato'] ?>.jpg"
                                    style="width: 100px; height: 100px; object-fit: cover;" alt="Hossomaki">
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

        <section id="uramaki" class="mb-5">
            <h2 class="category-title">Uramaki</h2>
            <div class="row g-4">
                <?php foreach ($pratos as $prato): ?>
                    <?php if ($prato['id_categoria'] == 4): ?>
                        <div class="col-md-6">
                            <div class="card card-sushi flex-row align-items-center p-3">
                                <img src="img/<?= $prato['id_prato'] ?>.jpg"
                                    style="width: 100px; height: 100px; object-fit: cover;" alt="Uramaki">
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
                    <?php if ($prato['id_categoria'] == 5): ?>
                        <div class="col-md-6">
                            <div class="card card-sushi flex-row align-items-center p-3">
                                <img src="img/<?= $prato['id_prato'] ?>.jpg"
                                    style="width: 100px; height: 100px; object-fit: cover;" alt="Sashimi">
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

        <section id="temakis" class="mb-5">
            <h2 class="category-title">Temakis</h2>
            <div class="row g-4">
                <?php foreach ($pratos as $prato): ?>
                    <?php if ($prato['id_categoria'] == 6): ?>
                        <div class="col-md-6">
                            <div class="card card-sushi flex-row align-items-center p-3">
                                <img src="img/<?= $prato['id_prato'] ?>.jpg"
                                    style="width: 100px; height: 100px; object-fit: cover;" alt="Temakis">
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

        <section id="hotrolls" class="mb-5">
            <h2 class="category-title">Hot Rolls</h2>
            <div class="row g-4">
                <?php foreach ($pratos as $prato): ?>
                    <?php if ($prato['id_categoria'] == 7): ?>
                        <div class="col-md-6">
                            <div class="card card-sushi flex-row align-items-center p-3">
                                <img src="img/<?= $prato['id_prato'] ?>.jpg"
                                    style="width: 100px; height: 100px; object-fit: cover;" alt="Hot Roll">
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

        <section id="renomados" class="mb-5">
            <h2 class="category-title">Pratos Renomados</h2>
            <div class="row g-4">
                <?php foreach ($pratos as $prato): ?>
                    <?php if ($prato['id_categoria'] == 8): ?>
                        <div class="col-md-6">
                            <div class="card card-sushi flex-row align-items-center p-3">
                                <img src="img/<?= $prato['id_prato'] ?>.jpg"
                                    style="width: 100px; height: 100px; object-fit: cover;" alt="Pratos Renomados">
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

        <section id="supremo" class="mb-5">
            <h2 class="category-title">Supremos</h2>
            <div class="row g-4">
                <?php foreach ($pratos as $prato): ?>
                    <?php if ($prato['id_categoria'] == 9): ?>
                        <div class="col-md-6">
                            <div class="card card-sushi flex-row align-items-center p-3">
                                <img src="img/<?= $prato['id_prato'] ?>.jpg"
                                    style="width: 100px; height: 100px; object-fit: cover;" alt="Sobremesas">
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

        <section id="bebidas" class="mb-5">
            <h2 class="category-title">Bebidas</h2>
            <div class="row g-4">
                <?php foreach ($pratos as $prato): ?>
                    <?php if ($prato['id_categoria'] == 10): ?>
                        <div class="col-md-6">
                            <div class="card card-sushi flex-row align-items-center p-3">
                                <img src="img/<?= $prato['id_prato'] ?>.jpg"
                                    style="width: 100px; height: 100px; object-fit: cover;" alt="Bebidas">
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

        <section id="alcoolicas" class="mb-5">
            <h2 class="category-title">Bebidas Alcoólicas</h2>
            <div class="row g-4">
                <?php foreach ($pratos as $prato): ?>
                    <?php if ($prato['id_categoria'] == 11): ?>
                        <div class="col-md-6">
                            <div class="card card-sushi flex-row align-items-center p-3">
                                <img src="img/<?= $prato['id_prato'] ?>.jpg"
                                    style="width: 100px; height: 100px; object-fit: cover;" alt="alcoolicas">
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

        <section id="combo" class="mb-5">
            <h2 class="category-title">Combinados</h2>
            <div class="row g-4">
                <?php foreach ($pratos as $prato): ?>
                    <?php if ($prato['id_categoria'] == 12): ?>
                        <div class="col-md-6">
                            <div class="card card-sushi flex-row align-items-center p-3">
                                <img src="img/<?= $prato['id_prato'] ?>.jpg"
                                    style="width: 100px; height: 100px; object-fit: cover;" alt="combos">
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

    <div class="modal fade" id="cartModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content cart-modal">
                <div class="modal-header border-bottom border-secondary">
                    <h5 class="modal-title">
                        <i class="bi bi-cart3"></i> Seu Carrinho
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="cartContent">
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-success" onclick="finalizarPedido()">
                        <i class="bi bi-check-circle"></i> Finalizar Pedido
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content cart-modal">
                <div class="modal-header border-bottom border-secondary">
                    <h5 class="modal-title">
                        <i class="bi bi-credit-card"></i> Formas de Pagamento
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="paymentContent">
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                    <button type="button" class="btn btn-primary" onclick="confirmarPedido()">
                        Confirmar Pedido
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Carregar carrinho do localStorage ou criar vazio
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Função para salvar carrinho no localStorage
        function saveCart() {
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
        }

        // Função para atualizar o contador do carrinho
        function updateCartCount() {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.querySelectorAll('.cart-count').forEach(el => {
                el.textContent = totalItems;
            });
        }

        // Função para adicionar item ao carrinho
        function addToCart(prato) {
            const existingItem = cart.find(item => item.id === prato.id);

            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({
                    id: prato.id,
                    nome: prato.nome,
                    preco: prato.preco,
                    quantity: 1
                });
            }

            saveCart();

            // Feedback visual
            const btn = event.target.closest('.btn-order');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check-lg"></i> Adicionado';
            btn.style.backgroundColor = '#28a745';

            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.style.backgroundColor = '#e63946';
            }, 1500);
        }

        // Função para remover item do carrinho
        function removeFromCart(itemId) {
            cart = cart.filter(item => item.id !== itemId);
            saveCart();
            displayCart();
        }

        // Função para atualizar quantidade
        function updateQuantity(itemId, change) {
            const item = cart.find(item => item.id === itemId);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    removeFromCart(itemId);
                } else {
                    saveCart();
                    displayCart();
                }
            }
        }

        // Função para limpar carrinho
        function clearCart() {
            if (confirm('Tem certeza que deseja limpar o carrinho?')) {
                cart = [];
                saveCart();
                displayCart();
            }
        }

        // Função para calcular total
        function calculateTotal() {
            return cart.reduce((sum, item) => sum + (item.preco * item.quantity), 0);
        }

        // Função para exibir o carrinho
        function displayCart() {
            const cartContent = document.getElementById('cartContent');

            if (cart.length === 0) {
                cartContent.innerHTML = `
                <div class="cart-empty">
                    <i class="bi bi-cart-x" style="font-size: 3rem;"></i>
                    <p class="mt-3">Seu carrinho está vazio!</p>
                    <button class="btn btn-primary" data-bs-dismiss="modal">
                        Continuar Comprando
                    </button>
                </div>
            `;
                return;
            }

            let html = '<div class="cart-items">';

            cart.forEach(item => {
                html += `
                <div class="cart-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">${item.nome}</h6>
                            <small class="text-secondary">R$ ${item.preco.toFixed(2)}</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-outline-danger" onclick="updateQuantity(${item.id}, -1)">
                                <i class="bi bi-dash"></i>
                            </button>
                            <span class="mx-2">${item.quantity}</span>
                            <button class="btn btn-sm btn-outline-success" onclick="updateQuantity(${item.id}, 1)">
                                <i class="bi bi-plus"></i>
                            </button>
                            <button class="btn btn-sm btn-danger ms-2" onclick="removeFromCart(${item.id})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            });

            html += `
            <div class="cart-total">
                <div class="d-flex justify-content-between">
                    <strong>Total:</strong>
                    <strong>R$ ${calculateTotal().toFixed(2)}</strong>
                </div>
            </div>
            <div class="mt-3">
                <button class="btn btn-clear-cart" onclick="clearCart()">
                    <i class="bi bi-trash3"></i> Limpar Carrinho
                </button>
            </div>
        </div>`;

            cartContent.innerHTML = html;
        }

        // Função para abrir o modal de pagamento
        function finalizarPedido() {
            if (cart.length === 0) {
                alert('Seu carrinho está vazio!');
                return;
            }

            const total = calculateTotal();
            const paymentContent = document.getElementById('paymentContent');

            paymentContent.innerHTML = `
            <div class="mb-4">
                <h6>Resumo do Pedido:</h6>
                <p class="text-secondary">Total de itens: ${cart.reduce((sum, item) => sum + item.quantity, 0)}</p>
                <h5 class="text-danger">Total: R$ ${total.toFixed(2)}</h5>
            </div>
            
            <h6 class="mb-3">Selecione a forma de pagamento:</h6>
            
            <div class="payment-method" onclick="selectPayment('Dinheiro')">
                <i class="bi bi-cash-stack"></i> Dinheiro
                <small class="text-secondary d-block">(10% de desconto)</small>
            </div>
            
            <div class="payment-method" onclick="selectPayment('Pix')">
                <i class="bi bi-qr-code"></i> Pix
                <small class="text-secondary d-block">(5% de desconto)</small>
            </div>
            
            <div class="payment-method" onclick="selectPayment('Cartão de Crédito')">
                <i class="bi bi-credit-card"></i> Cartão de Crédito
                <small class="text-secondary d-block">(Até 3x sem juros)</small>
            </div>
            
            <div class="payment-method" onclick="selectPayment('Cartão de Débito')">
                <i class="bi bi-bank2"></i> Cartão de Débito
            </div>
            
            <input type="hidden" id="selectedPayment" value="">
        `;

            // Fechar modal do carrinho e abrir modal de pagamento
            bootstrap.Modal.getInstance(document.getElementById('cartModal')).hide();
            new bootstrap.Modal(document.getElementById('paymentModal')).show();
        }

        // Função para selecionar forma de pagamento
        let selectedPayment = '';

        function selectPayment(payment) {
            selectedPayment = payment;

            // Remover seleção anterior
            document.querySelectorAll('.payment-method').forEach(el => {
                el.classList.remove('selected');
            });

            // Adicionar seleção ao elemento clicado
            event.target.closest('.payment-method').classList.add('selected');
            document.getElementById('selectedPayment').value = payment;
        }

        // Função para confirmar pedido
        function confirmarPedido() {
            if (!selectedPayment) {
                alert('Por favor, selecione uma forma de pagamento!');
                return;
            }

            const total = calculateTotal();
            let finalTotal = total;
            let desconto = 0;

            if (selectedPayment === 'Dinheiro') {
                desconto = total * 0.1;
                finalTotal = total - desconto;
            } else if (selectedPayment === 'Pix') {
                desconto = total * 0.05;
                finalTotal = total - desconto;
            }

            // Criar mensagem do pedido
            let mensagem = `**NOVO PEDIDO - WABI-SABI**\n\n`;
            mensagem += `*Itens do pedido:*\n`;
            cart.forEach(item => {
                mensagem += `• ${item.quantity}x ${item.nome} - R$ ${(item.preco * item.quantity).toFixed(2)}\n`;
            });
            mensagem += `\n*Subtotal:* R$ ${total.toFixed(2)}`;

            if (desconto > 0) {
                mensagem += `\n*Desconto:* -R$ ${desconto.toFixed(2)}`;
            }

            mensagem += `\n*Total:* R$ ${finalTotal.toFixed(2)}`;
            mensagem += `\n*Forma de Pagamento:* ${selectedPayment}`;

            // Simular envio do pedido (aqui você pode enviar para WhatsApp, API, etc)
            alert(`Pedido confirmado!\n\n${mensagem}\n\nObrigado pela preferência!`);

            // Limpar carrinho após confirmação
            cart = [];
            saveCart();

            // Fechar modal
            bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();

            // Mostrar modal de carrinho vazio
            displayCart();
        }

        // Adicionar evento aos botões "Adicionar"
        document.querySelectorAll('.btn-order').forEach(btn => {
            const card = btn.closest('.card-sushi');
            const nome = card.querySelector('h5').innerText;
            const precoText = card.querySelector('.price-tag').innerText;
            const preco = parseFloat(precoText.replace('R$ ', '').replace(',', '.'));

            // Gerar ID único baseado no nome (simplificado)
            const id = nome.hashCode ? nome.hashCode() : Math.random();

            btn.addEventListener('click', function () {
                addToCart({
                    id: id,
                    nome: nome,
                    preco: preco
                });
            });
        });

        // Função para abrir o modal do carrinho
        document.querySelector('.nav-icons .position-relative').addEventListener('click', function (e) {
            e.preventDefault();
            displayCart();
            new bootstrap.Modal(document.getElementById('cartModal')).show();
        });

        // Inicializar contador do carrinho
        updateCartCount();

        // Função auxiliar para hash (caso necessário)
        String.prototype.hashCode = function () {
            let hash = 0;
            for (let i = 0; i < this.length; i++) {
                hash = ((hash << 5) - hash) + this.charCodeAt(i);
                hash |= 0;
            }
            return hash;
        };
    </script>
</body>

</html>