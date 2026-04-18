<?php
session_start();
include "conexao.php";

// Processar login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao'])) {
    if ($_POST['acao'] == 'login') {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_email'] = $usuario['email'];
            header("Location: cardapio.php");
            exit();
        } else {
            $erro = "Email ou senha inválidos!";
        }
    } elseif ($_POST['acao'] == 'registro') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $endereco = $_POST['endereco'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO usuarios (nome, email, telefone, endereco, senha) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([$nome, $email, $telefone, $endereco, $senha]);
            $sucesso = "Cadastro realizado com sucesso! Faça login.";
        } catch(PDOException $e) {
            $erro = "Email já cadastrado!";
        }
    }
}

// Processar logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: cardapio.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sushi Wabi-Sabi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('https://images.unsplash.com/photo-1579871494447-9811cf80d66c?auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            min-height: 100vh;
        }
        .login-container {
            max-width: 500px;
            margin: 50px auto;
        }
        .card {
            background: rgba(26, 26, 26, 0.95);
            border: 1px solid #333;
            border-radius: 15px;
            color: white;
        }
        .card-header {
            background: #e63946;
            color: white;
            text-align: center;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
        }
        .form-control, .form-select {
            background-color: #0b0b0b;
            border: 1px solid #333;
            color: white;
        }
        .form-control:focus {
            background-color: #0b0b0b;
            color: white;
            border-color: #e63946;
            box-shadow: none;
        }
        .btn-login {
            background-color: #e63946;
            color: white;
            width: 100%;
            padding: 10px;
        }
        .btn-login:hover {
            background-color: #d4af37;
            color: #1a1a1a;
        }
        .nav-tabs .nav-link {
            color: white;
            background-color: #1a1a1a;
            border: none;
        }
        .nav-tabs .nav-link.active {
            background-color: #e63946;
            color: white;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="card">
            <div class="card-header">
                <h3><i class="bi bi-person-circle"></i> Sushi Wabi-Sabi</h3>
                <p>Faça login ou crie sua conta</p>
            </div>
            <div class="card-body p-4">
                <?php if (isset($erro)): ?>
                    <div class="alert alert-danger"><?= $erro ?></div>
                <?php endif; ?>
                <?php if (isset($sucesso)): ?>
                    <div class="alert alert-success"><?= $sucesso ?></div>
                <?php endif; ?>
                
                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">Login</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">Cadastro</button>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="login" role="tabpanel">
                        <form method="POST">
                            <input type="hidden" name="acao" value="login">
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Senha</label>
                                <input type="password" name="senha" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-login">Entrar</button>
                        </form>
                    </div>
                    
                    <div class="tab-pane fade" id="register" role="tabpanel">
                        <form method="POST">
                            <input type="hidden" name="acao" value="registro">
                            <div class="mb-3">
                                <label>Nome completo</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Telefone</label>
                                <input type="tel" name="telefone" class="form-control" placeholder="(11) 99999-9999">
                            </div>
                            <div class="mb-3">
                                <label>Endereço</label>
                                <textarea name="endereco" class="form-control" rows="2" placeholder="Rua, número, bairro, complemento"></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Senha</label>
                                <input type="password" name="senha" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Confirmar senha</label>
                                <input type="password" name="confirmar_senha" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-login">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>