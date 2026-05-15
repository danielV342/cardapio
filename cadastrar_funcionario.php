<?php
session_start();

// Verificar se é chef (apenas admin pode cadastrar)
if (!isset($_SESSION['funcionario_id']) || $_SESSION['funcionario_cargo'] !== 'chef') {
    header("Location: login_cozinha.php");
    exit();
}

include "conexao.php";

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cargo = $_POST['cargo']; // 'chef' ou 'cozinheiro'
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    
    // Verificar se email já existe
    $check = $pdo->prepare("SELECT id_funcionario FROM funcionarios WHERE email = ?");
    $check->execute([$email]);
    if ($check->fetch()) {
        $erro = "Email já cadastrado!";
    } else {
        $sql = "INSERT INTO funcionarios (nome, email, cargo, senha, ativo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$nome, $email, $cargo, $senha, $ativo]);
            $sucesso = "Funcionário cadastrado com sucesso!";
        } catch (PDOException $e) {
            $erro = "Erro ao cadastrar: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Funcionário - Cozinha</title>
    <link rel="shortcut icon" href="img/logo-sushi.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #0b0b0b; color: #fff; }
        .container { max-width: 600px; margin-top: 50px; }
        .card { background: #1a1a1a; border: 1px solid #e63946; border-radius: 15px; }
        .card-header { background: #e63946; text-align: center; }
        .form-control, .form-select { background-color: #0b0b0b; border: 1px solid #333; color: white; }
        .btn-primary { background-color: #e63946; border: none; }
        .btn-primary:hover { background-color: #d4af37; color: #1a1a1a; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3><i class="bi bi-person-plus"></i> Cadastrar Novo Funcionário</h3>
            <small>Apenas Chef tem permissão</small>
        </div>
        <div class="card-body p-4">
            <?php if ($erro): ?>
                <div class="alert alert-danger"><?= $erro ?></div>
            <?php endif; ?>
            <?php if ($sucesso): ?>
                <div class="alert alert-success"><?= $sucesso ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label>Nome completo</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Cargo</label>
                    <select name="cargo" class="form-select" required>
                        <option value="cozinheiro">Cozinheiro</option>
                        <option value="chef">Chef (Administrador)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Senha</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="ativo" class="form-check-input" id="ativo" checked>
                    <label class="form-check-label" for="ativo">Usuário ativo</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">Cadastrar Funcionário</button>
                <a href="cozinha.php" class="btn btn-secondary w-100 mt-2">Voltar para Cozinha</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>