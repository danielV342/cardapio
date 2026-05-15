<?php
session_start();

// Verificar se é funcionário da cozinha
if (!isset($_SESSION['funcionario_id'])) {
    header("Location: login_cozinha.php");
    exit();
}

// Verificar se o cargo é permitido (chef ou cozinheiro)
$cargosPermitidos = ['chef', 'cozinheiro'];
if (!isset($_SESSION['funcionario_cargo']) || !in_array($_SESSION['funcionario_cargo'], $cargosPermitidos)) {
    // Se não tiver cargo permitido, destruir sessão e redirecionar
    session_destroy();
    header("Location: login_cozinha.php?erro=acesso_negado");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel da Cozinha - Sushi Wabi-Sabi</title>
    <link rel="shortcut icon" href="img/logo-sushi.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #0b0b0b;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
        }

        .navbar {
            background: #1a1a1a !important;
            border-bottom: 1px solid #e63946;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .navbar-brand span {
            color: #e63946;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: bold;
        }

        .status-pendente {
            background-color: #ffc107;
            color: #1a1a1a;
        }

        .status-preparando {
            background-color: #17a2b8;
            color: white;
        }

        .status-concluido {
            background-color: #28a745;
            color: white;
        }

        .status-cancelado {
            background-color: #dc3545;
            color: white;
        }

        .pedido-card {
            background: #1a1a1a;
            border: 1px solid #333;
            border-radius: 12px;
            transition: all 0.3s ease;
            height: 100%;
        }

        .pedido-card:hover {
            transform: translateY(-5px);
            border-color: #e63946;
            box-shadow: 0 5px 20px rgba(230, 57, 70, 0.2);
        }

        .pedido-header {
            background: linear-gradient(135deg, #e63946, #c1121f);
            border-radius: 12px 12px 0 0;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pedido-numero {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .pedido-hora {
            font-size: 0.8rem;
            opacity: 0.9;
        }

        .pedido-body {
            padding: 15px;
        }

        .item-lista {
            border-bottom: 1px solid #333;
            padding: 8px 0;
        }

        .item-lista:last-child {
            border-bottom: none;
        }

        .item-nome {
            font-weight: 500;
        }

        .item-quantidade {
            color: #e63946;
            font-weight: bold;
        }

        .btn-acao {
            margin: 3px;
            padding: 6px 12px;
            font-size: 0.8rem;
        }

        .nav-tabs {
            border-bottom: 1px solid #333;
        }

        .nav-tabs .nav-link {
            color: #b0b0b0;
            background: transparent;
            border: none;
            font-weight: 500;
        }

        .nav-tabs .nav-link:hover {
            color: #e63946;
        }

        .nav-tabs .nav-link.active {
            color: #e63946;
            background: transparent;
            border-bottom: 2px solid #e63946;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .novo-pedido {
            animation: pulse 0.5s ease-in-out;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1a1a1a;
        }

        ::-webkit-scrollbar-thumb {
            background: #e63946;
            border-radius: 4px;
        }

        .badge-count {
            background-color: #e63946;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.7rem;
            margin-left: 5px;
        }

        .modal-content {
            background-color: #1a1a1a;
            border: 1px solid #333;
            color: white;
        }

        .modal-header {
            border-bottom-color: #333;
        }

        .modal-footer {
            border-top-color: #333;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="img/logo-sushi.png" alt="Logo" width="35" height="35">
                WABI-SABI <span> | Cozinha </span>
            </a>
            <div class="d-flex align-items-center gap-3">
                <span class="text-light">
                    <i class="bi bi-person-badge"></i>
                    <?= $_SESSION['funcionario_nome'] ?>
                    <?php if ($_SESSION['funcionario_cargo'] == 'chef'): ?>
                        <span class="badge bg-warning text-dark ms-1">
                            <i class="bi bi-star-fill"></i> Chef
                        </span>
                    <?php else: ?>
                        <span class="badge bg-info ms-1">
                            <i class="bi bi-egg-fried"></i> Cozinheiro
                        </span>
                    <?php endif; ?>
                </span>

                <?php if ($_SESSION['funcionario_cargo'] == 'chef'): ?>
                    <a href="cadastrar_funcionario.php" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-person-plus"></i> Novo Funcionário
                    </a>
                <?php endif; ?>

                <a href="login_cozinha.php?logout=1" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Sair
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <ul class="nav nav-tabs mb-4" id="pedidosTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="ativos-tab" data-bs-toggle="tab" data-bs-target="#ativos"
                    type="button" role="tab">
                    <i class="bi bi-clock-history"></i> Em Andamento
                    <span id="ativosCount" class="badge-count">0</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="historico-tab" data-bs-toggle="tab" data-bs-target="#historico"
                    type="button" role="tab">
                    <i class="bi bi-archive"></i> Histórico
                </button>
            </li>
        </ul>

        <div class="tab-content" id="pedidosTabContent">
            <div class="tab-pane fade show active" id="ativos" role="tabpanel">
                <div class="row g-4" id="pedidosAtivosContainer">
                    <div class="col-12 text-center py-5">
                        <div class="spinner-border text-danger" role="status">
                            <span class="visually-hidden">Carregando...</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="historico" role="tabpanel">
                <div class="row g-4" id="historicoContainer">
                    <div class="col-12 text-center py-5">
                        <div class="spinner-border text-danger" role="status">
                            <span class="visually-hidden">Carregando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detalhesModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-receipt"></i> Detalhes do Pedido
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detalhesContent">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let audioContext = null;
        let ultimoPedidoId = null;

        // Reproduzir som de notificação
        function playNotificationSound() {
            try {
                if (!audioContext) {
                    audioContext = new (window.AudioContext || window.webkitAudioContext)();
                }
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                oscillator.frequency.value = 880;
                gainNode.gain.value = 0.3;
                oscillator.start();
                gainNode.gain.exponentialRampToValueAtTime(0.00001, audioContext.currentTime + 1);
                oscillator.stop(audioContext.currentTime + 1);
            } catch (e) {
                console.log('Som não suportado');
            }
        }

        // Formatar data/hora
        function formatarData(data) {
            const d = new Date(data);
            return d.toLocaleDateString('pt-BR') + ' ' + d.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
        }

        function getStatusBadge(status) {
            const statusMap = {
                'pendente': 'status-pendente',
                'preparando': 'status-preparando',
                'concluido': 'status-concluido',
                'cancelado': 'status-cancelado'
            };
            const textMap = {
                'pendente': '⏳ Pendente',
                'preparando': '🍳 Preparando',
                'concluido': '✅ Concluído',
                'cancelado': '❌ Cancelado'
            };
            return `<span class="status-badge ${statusMap[status] || 'status-pendente'}">${textMap[status] || status}</span>`;
        }

        function renderPedidoCard(pedido, isHistorico = false) {
            const itens = pedido.itens || [];
            const hora = formatarData(pedido.data_pedido);

            let html = `
            <div class="col-md-6 col-lg-4">
                <div class="pedido-card" data-pedido-id="${pedido.id_pedido}">
                    <div class="pedido-header">
                        <div>
                            <div class="pedido-numero">${pedido.numero_pedido}</div>
                            <div class="pedido-hora"><i class="bi bi-clock"></i> ${hora}</div>
                        </div>
                        ${getStatusBadge(pedido.status)}
                    </div>
                    <div class="pedido-body">
                        <div class="mb-2">
                            <small class="text-secondary"><i class="bi bi-person"></i> Cliente:</small>
                            <div>${pedido.cliente_nome || 'Cliente não identificado'}</div>
                        </div>
                        <div class="mb-2">
                            <small class="text-secondary"><i class="bi bi-cup-straw"></i> Itens:</small>
        `;

            itens.forEach(item => {
                html += `
                <div class="item-lista d-flex justify-content-between align-items-center">
                    <span class="item-nome">${item.nome}</span>
                    <span class="item-quantidade">${item.quantidade}x</span>
                </div>
            `;
            });

            html += `
                        </div>
                        <div class="mt-3 pt-2 border-top border-secondary">
                            <div class="d-flex justify-content-between">
                                <strong>Total:</strong>
                                <strong class="text-danger">R$ ${parseFloat(pedido.total).toFixed(2)}</strong>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small>Subtotal:</small>
                                <small>R$ ${parseFloat(pedido.subtotal).toFixed(2)}</small>
                            </div>
                            ${pedido.desconto > 0 ? `<div class="d-flex justify-content-between mt-1"><small>Desconto:</small><small>- R$ ${parseFloat(pedido.desconto).toFixed(2)}</small></div>` : ''}
                            <div class="d-flex justify-content-between mt-1">
                                <small>Pagamento:</small>
                                <small>${pedido.forma_pagamento || 'Não informado'}</small>
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-2">
                            <button class="btn btn-sm btn-outline-info flex-grow-1" onclick="verDetalhes(${pedido.id_pedido})">
                                <i class="bi bi-eye"></i> Detalhes
                            </button>
        `;

            if (!isHistorico) {
                if (pedido.status === 'pendente') {
                    html += `<button class="btn btn-sm btn-outline-warning flex-grow-1" onclick="atualizarStatus(${pedido.id_pedido}, 'preparando')">
                            <i class="bi bi-play-fill"></i> Iniciar
                        </button>`;
                } else if (pedido.status === 'preparando') {
                    html += `<button class="btn btn-sm btn-outline-success flex-grow-1" onclick="atualizarStatus(${pedido.id_pedido}, 'concluido')">
                            <i class="bi bi-check-lg"></i> Concluir
                        </button>`;
                }
            }

            html += `
                        </div>
                    </div>
                </div>
            </div>
        `;

            return html;
        }

        async function carregarPedidosAtivos() {
            try {
                const response = await fetch('api_pedidos.php?action=pedidos_pendentes');
                const pedidos = await response.json();

                const container = document.getElementById('pedidosAtivosContainer');
                const ativosCount = document.getElementById('ativosCount');

                if (pedidos.length === 0) {
                    container.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 48px; color: #666;"></i>
                        <p class="mt-3 text-secondary">Nenhum pedido pendente no momento</p>
                    </div>
                `;
                    ativosCount.textContent = '0';
                    return;
                }

                // Verificar novos pedidos
                const novosIds = pedidos.map(p => p.id_pedido);
                if (ultimoPedidoId && !novosIds.includes(ultimoPedidoId)) {
                    playNotificationSound();
                }
                ultimoPedidoId = novosIds[0];

                let html = '';
                pedidos.forEach(pedido => {
                    html += renderPedidoCard(pedido, false);
                });
                container.innerHTML = html;
                ativosCount.textContent = pedidos.length;

            } catch (error) {
                console.error('Erro ao carregar pedidos:', error);
            }
        }

        async function carregarHistorico() {
            try {
                const response = await fetch('api_pedidos.php?action=historico_pedidos');
                const pedidos = await response.json();

                const container = document.getElementById('historicoContainer');

                if (pedidos.length === 0) {
                    container.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-archive" style="font-size: 48px; color: #666;"></i>
                        <p class="mt-3 text-secondary">Nenhum pedido concluído</p>
                    </div>
                `;
                    return;
                }

                let html = '';
                pedidos.forEach(pedido => {
                    html += renderPedidoCard(pedido, true);
                });
                container.innerHTML = html;

            } catch (error) {
                console.error('Erro ao carregar histórico:', error);
            }
        }

        async function verDetalhes(idPedido) {
            try {
                const response = await fetch(`api_pedidos.php?action=buscar_pedido&id=${idPedido}`);
                const pedido = await response.json();

                if (pedido.error) {
                    alert(pedido.error);
                    return;
                }

                const itens = pedido.itens || [];
                let itensHtml = '<table class="table table-dark table-sm">';
                itensHtml += '<thead><tr><th>Item</th><th>Quantidade</th><th>Preço Unit.</th><th>Subtotal</th></tr></thead><tbody>';

                itens.forEach(item => {
                    const precoUnit = item.preco / item.quantidade;
                    itensHtml += `
                    <tr>
                        <td>${item.nome}</td>
                        <td>${item.quantidade}x</td>
                        <td>R$ ${precoUnit.toFixed(2)}</td>
                        <td>R$ ${item.preco.toFixed(2)}</td>
                    </tr>
                `;
                });

                itensHtml += '</tbody></table>';

                const html = `
                <div class="mb-3">
                    <h6><i class="bi bi-receipt"></i> Pedido: ${pedido.numero_pedido}</h6>
                    <p><strong>Cliente:</strong> ${pedido.cliente_nome || 'Não identificado'}</p>
                    <p><strong>Telefone:</strong> ${pedido.telefone || 'Não informado'}</p>
                    <p><strong>Endereço:</strong> ${pedido.endereco || 'Não informado'}</p>
                    <p><strong>Data:</strong> ${formatarData(pedido.data_pedido)}</p>
                    <p><strong>Status:</strong> ${getStatusBadge(pedido.status)}</p>
                </div>
                <h6>Itens do pedido:</h6>
                ${itensHtml}
                <div class="mt-3 pt-2 border-top border-secondary">
                    <div class="d-flex justify-content-between">
                        <strong>Subtotal:</strong>
                        <span>R$ ${parseFloat(pedido.subtotal).toFixed(2)}</span>
                    </div>
                    ${pedido.desconto > 0 ? `
                        <div class="d-flex justify-content-between">
                            <strong>Desconto:</strong>
                            <span>- R$ ${parseFloat(pedido.desconto).toFixed(2)}</span>
                        </div>
                    ` : ''}
                    <div class="d-flex justify-content-between mt-2">
                        <strong class="text-danger">Total:</strong>
                        <strong class="text-danger">R$ ${parseFloat(pedido.total).toFixed(2)}</strong>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <small>Forma de pagamento:</small>
                        <small>${pedido.forma_pagamento || 'Não informado'}</small>
                    </div>
                </div>
                ${pedido.observacoes ? `
                    <div class="mt-3 p-2 bg-dark rounded">
                        <small><i class="bi bi-chat-text"></i> Observações do cliente:</small>
                        <p class="mb-0">${pedido.observacoes}</p>
                    </div>
                ` : ''}
            `;

                document.getElementById('detalhesContent').innerHTML = html;
                new bootstrap.Modal(document.getElementById('detalhesModal')).show();

            } catch (error) {
                console.error('Erro ao carregar detalhes:', error);
                alert('Erro ao carregar detalhes do pedido');
            }
        }

        // Atualizar status do pedido
        async function atualizarStatus(idPedido, novoStatus) {
            try {
                const response = await fetch('api_pedidos.php?action=atualizar_status', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id_pedido: idPedido, status: novoStatus })
                });
                const result = await response.json();

                if (result.success) {
                    // Recarregar lista
                    carregarPedidosAtivos();
                    if (novoStatus === 'concluido') {
                        carregarHistorico();
                    }
                    playNotificationSound();
                } else {
                    alert('Erro ao atualizar status');
                }
            } catch (error) {
                console.error('Erro:', error);
                alert('Erro ao atualizar status');
            }
        }

        // Atualização automática a cada 10 segundos
        setInterval(() => {
            const activeTab = document.querySelector('#pedidosTab .nav-link.active');
            if (activeTab && activeTab.id === 'ativos-tab') {
                carregarPedidosAtivos();
            }
        }, 10000);

        document.addEventListener('DOMContentLoaded', () => {
            carregarPedidosAtivos();
            carregarHistorico();
        });
    </script>
</body>

</html>