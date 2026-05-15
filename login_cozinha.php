<?php
session_start();
include "conexao.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Se já estiver logado na cozinha, redirecionar
if (isset($_SESSION['funcionario_id'])) {
    header("Location: cozinha.php");
    exit();
}

// Logout da cozinha
if (isset($_GET['logout'])) {
    // Remove todas as variáveis de sessão
    $_SESSION = array();

    // Destroi a sessão no servidor
    session_destroy();

    // Remove o cookie de sessão (força o navegador a esquecer o PHPSESSID)
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Redireciona para a página de login da cozinha
    header("Location: /cardapio/login_cozinha.php");
    exit();
}

$erro = '';

// Processar login da cozinha
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    // Verificar se é funcionário da cozinha (cargo chef ou cozinheiro)
    $sql = "SELECT * FROM funcionarios WHERE email = ? AND ativo = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($funcionario && password_verify($senha, $funcionario['senha'])) {
        // Verificar se o cargo é permitido (chef ou cozinheiro)
        $cargosPermitidos = ['chef', 'cozinheiro'];
        
        if (in_array($funcionario['cargo'], $cargosPermitidos)) {
            $_SESSION['funcionario_id'] = $funcionario['id_funcionario'];
            $_SESSION['funcionario_nome'] = $funcionario['nome'];
            $_SESSION['funcionario_cargo'] = $funcionario['cargo'];
            $_SESSION['funcionario_email'] = $funcionario['email'];
            
            header("Location: cozinha.php");
            exit();
        } else {
            $erro = "Acesso negado! Você não tem permissão para acessar a cozinha.";
        }
    } else {
        $erro = "Email ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Cozinha - Sushi Wabi-Sabi</title>
    <link rel="shortcut icon" href="img/logo-sushi.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('https://images.unsplash.com/photo-1579871494447-9811cf80d66c?auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            min-height: 100vh;
        }
        .login-container {
            max-width: 450px;
            margin: 80px auto;
        }
        .card {
            background: rgba(26, 26, 26, 0.95);
            border: 1px solid #e63946;
            border-radius: 15px;
            color: white;
        }
        .card-header {
            background: #e63946;
            color: white;
            text-align: center;
            border-radius: 15px 15px 0 0 !important;
            padding: 25px;
        }
        .card-header h3 i {
            font-size: 3rem;
        }
        .form-control {
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
            padding: 12px;
            font-weight: bold;
        }
        .btn-login:hover {
            background-color: #d4af37;
            color: #1a1a1a;
        }
        .badge-chef {
            background-color: #d4af37;
            color: #1a1a1a;
        }
        .badge-cozinheiro {
            background-color: #17a2b8;
            color: white;
        }
        .info-cargos {
            background: rgba(0,0,0,0.5);
            border-radius: 8px;
            padding: 10px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="card">
            <div class="card-header">
                <img src="img/logo-sushi.png" alt="Logo" width="50" height="50">
                <h3 class="mt-2">Área da Cozinha</h3>
                <p class="mb-0">Acesso restrito para equipe</p>
            </div>
            <div class="card-body p-4">
                <?php if ($erro): ?>
                    <div class="alert alert-danger"><?= $erro ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label><i class="bi bi-envelope"></i> Email</label>
                        <input type="email" name="email" class="form-control" required placeholder="chef@wabisabi.com">
                    </div>
                    <div class="mb-4">
                        <label><i class="bi bi-lock"></i> Senha</label>
                        <input type="password" name="senha" class="form-control" required placeholder="********">
                    </div>
                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right"></i> Entrar na Cozinha
                    </button>
                </form>
                
                <div class="info-cargos text-center">
                    <small class="text-secondary">
                        <i class="bi bi-info-circle"></i> Apenas <span class="badge-chef badge">Chef</span> e 
                        <span class="badge-cozinheiro badge">Cozinheiros</span> têm acesso
                    </small>
                </div>
                
                <hr class="border-secondary my-3">
                
                <!-- <div class="text-center">
                    <small>
                        <a href="login.php" class="text-decoration-none">
                            <i class="bi bi-arrow-left"></i> Área do Cliente
                        </a>
                    </small>
                </div> -->
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>