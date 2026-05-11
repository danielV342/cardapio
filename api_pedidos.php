<?php
session_start();
header('Content-Type: application/json');
include "conexao.php";

// Verificar se está logado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'Não autorizado']);
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

// Salvar novo pedido
if ($action == 'salvar_pedido' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $id_usuario = $_SESSION['usuario_id'];
    $numero_pedido = 'PED-' . strtoupper(uniqid());
    $itens = json_encode($data['itens']);
    $subtotal = $data['subtotal'];
    $desconto = $data['desconto'];
    $total = $data['total'];
    $forma_pagamento = $data['pagamento'];
    $observacoes = $data['observacoes'] ?? '';
    
    $sql = "INSERT INTO pedidos (id_usuario, numero_pedido, itens, subtotal, desconto, total, forma_pagamento, observacoes) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$id_usuario, $numero_pedido, $itens, $subtotal, $desconto, $total, $forma_pagamento, $observacoes])) {
        $id_pedido = $pdo->lastInsertId();
        
        // Registrar log
        $logSql = "INSERT INTO pedido_status_log (id_pedido, status_anterior, status_novo, alterado_por) VALUES (?, NULL, 'pendente', ?)";
        $logStmt = $pdo->prepare($logSql);
        $logStmt->execute([$id_pedido, $_SESSION['usuario_nome']]);
        
        echo json_encode(['success' => true, 'numero_pedido' => $numero_pedido]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erro ao salvar pedido']);
    }
    exit();
}

// Buscar pedidos pendentes (para cozinha)
if ($action == 'pedidos_pendentes') {
    $sql = "SELECT p.*, u.nome as cliente_nome 
            FROM pedidos p 
            LEFT JOIN usuarios u ON p.id_usuario = u.id_usuario 
            WHERE p.status IN ('pendente', 'preparando') 
            ORDER BY p.data_pedido ASC";
    $stmt = $pdo->query($sql);
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($pedidos as &$pedido) {
        $pedido['itens'] = json_decode($pedido['itens'], true);
    }
    
    echo json_encode($pedidos);
    exit();
}

// Buscar histórico de pedidos (para cozinha)
if ($action == 'historico_pedidos') {
    $sql = "SELECT p.*, u.nome as cliente_nome 
            FROM pedidos p 
            LEFT JOIN usuarios u ON p.id_usuario = u.id_usuario 
            WHERE p.status IN ('concluido', 'cancelado') 
            ORDER BY p.data_pedido DESC LIMIT 50";
    $stmt = $pdo->query($sql);
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($pedidos as &$pedido) {
        $pedido['itens'] = json_decode($pedido['itens'], true);
    }
    
    echo json_encode($pedidos);
    exit();
}

// Atualizar status do pedido
if ($action == 'atualizar_status' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_pedido = $data['id_pedido'];
    $novo_status = $data['status'];
    
    // Buscar status atual
    $sql = "SELECT status FROM pedidos WHERE id_pedido = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_pedido]);
    $status_anterior = $stmt->fetchColumn();
    
    // Atualizar status
    $sql = "UPDATE pedidos SET status = ? WHERE id_pedido = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$novo_status, $id_pedido])) {
        // Registrar log
        $logSql = "INSERT INTO pedido_status_log (id_pedido, status_anterior, status_novo, alterado_por) VALUES (?, ?, ?, ?)";
        $logStmt = $pdo->prepare($logSql);
        $logStmt->execute([$id_pedido, $status_anterior, $novo_status, $_SESSION['usuario_nome']]);
        
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    exit();
}

// Buscar um pedido específico
if ($action == 'buscar_pedido' && isset($_GET['id'])) {
    $id_pedido = $_GET['id'];
    $sql = "SELECT p.*, u.nome as cliente_nome, u.telefone, u.endereco 
            FROM pedidos p 
            LEFT JOIN usuarios u ON p.id_usuario = u.id_usuario 
            WHERE p.id_pedido = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_pedido]);
    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($pedido) {
        $pedido['itens'] = json_decode($pedido['itens'], true);
        echo json_encode($pedido);
    } else {
        echo json_encode(['error' => 'Pedido não encontrado']);
    }
    exit();
}

echo json_encode(['error' => 'Ação inválida']);
?>