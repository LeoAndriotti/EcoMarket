<?php
session_start();
require_once 'config/bootstrap.php';
require_once 'classes/Usuario.php';
require_once 'classes/Produto.php';
require_once 'config/config.php';

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$usuario = null;
$produtos = [];
$mensagem = '';

if (isset($_GET['msg'])) {
    switch ($_GET['msg']) {
        case 'editado':
            $mensagem = '<div class="alert alert--success">Produto editado com sucesso.</div>';
            break;
        case 'excluido':
            $mensagem = '<div class="alert alert--success">Produto excluído com sucesso.</div>';
            break;
        case 'criado':
            $mensagem = '<div class="alert alert--success">Produto criado com sucesso.</div>';
            break;
        case 'erro':
            $mensagem = '<div class="alert alert--error">Erro ao processar a operação.</div>';
            break;
    }
}

if (isset($_SESSION['id'])) {
    $usuarioObj = new Usuario($conn);
    $usuario = $usuarioObj->buscarPorId($_SESSION['id']);
    $produtos = Produto::buscarPorProdutor($_SESSION['id']);

    $dadosGrafico = [];
    foreach ($produtos as $produto) {
        $categoria = $produto->categoria;
        if (!isset($dadosGrafico[$categoria])) {
            $dadosGrafico[$categoria] = 0;
        }
        $dadosGrafico[$categoria]++;
    }

    $labelsGrafico = array_keys($dadosGrafico);
    $dadosGrafico = array_values($dadosGrafico);
} else {
    session_destroy();
    header('Location: login.php');
    exit;
}

$pageTitle = 'Painel do produtor — EcoMarket';
$bodyClass = 'page-dashboard';
$navActive = 'dashboard';
$extraStyles = ['styles/pages/dashboard.css'];
require_once 'includes/head.php';
require_once 'includes/navbar.php';
?>

<main class="page-wrap dashboard">
    <div class="container">
        <section class="dashboard-hero">
            <div>
                <h1>Painel do produtor</h1>
                <?php if ($usuario): ?>
                    <p>Olá, <strong><?php echo htmlspecialchars($usuario['nome']); ?></strong> — gerencie suas ofertas de commodities.</p>
                <?php endif; ?>
            </div>
            <div class="dashboard-hero__actions">
                <button type="button" class="btn btn--ghost" onclick="editarUsuario()">Editar perfil</button>
                <a href="index.php" class="btn btn--ghost">Vitrine</a>
            </div>
        </section>

        <?php if ($mensagem): echo $mensagem; endif; ?>

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-card__value"><?php echo count($produtos); ?></div>
                <div class="stat-card__label">Produtos ativos</div>
            </div>
            <div class="stat-card">
                <div class="stat-card__value"><?php echo count(array_unique(array_map(function ($p) { return $p->categoria; }, $produtos))); ?></div>
                <div class="stat-card__label">Categorias</div>
            </div>
        </div>

        <div class="toolbar">
            <div class="toolbar__actions">
                <button type="button" class="btn btn--primary" onclick="window.location.href='cadastrarProduto.php'">+ Novo produto</button>
                <button type="button" class="btn btn--secondary" onclick="abrirModalProdutos()">Ver meus produtos</button>
            </div>
        </div>

        <section class="chart-card">
            <h2>Distribuição por categoria</h2>
            <?php if (empty($produtos)): ?>
                <div class="chart-empty">
                    <p>Nenhum produto cadastrado. Adicione sua primeira commodity para visualizar o gráfico.</p>
                    <button type="button" class="btn btn--primary" onclick="window.location.href='cadastrarProduto.php'">Cadastrar produto</button>
                </div>
            <?php else: ?>
                <div class="chart-wrapper">
                    <canvas id="graficoPizza" height="280"></canvas>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>

<div class="modal-overlay" id="modalProdutos">
    <div class="modal-produtos">
        <button type="button" class="modal__close" onclick="fecharModalProdutos()" aria-label="Fechar">&times;</button>
        <h3>Meus produtos</h3>
        <div class="produtos-container">
            <?php if (empty($produtos)): ?>
                <div class="empty-state">
                    <h4>Nenhum produto cadastrado</h4>
                    <p>Comece publicando sua primeira oferta na vitrine.</p>
                    <button type="button" class="btn btn--primary" onclick="window.location.href='cadastrarProduto.php'">Cadastrar produto</button>
                </div>
            <?php else: ?>
                <?php foreach ($produtos as $produto): ?>
                    <div class="product-list-item">
                        <img src="<?php echo htmlspecialchars($produto->imagem ?: 'uploads/placeholder.svg'); ?>"
                             alt="<?php echo htmlspecialchars($produto->nome); ?>"
                             onerror="this.src='uploads/placeholder.svg'">
                        <div class="product-list-item__info">
                            <h4><?php echo htmlspecialchars($produto->nome); ?></h4>
                            <p><?php echo htmlspecialchars($produto->descricao); ?></p>
                            <div class="product-list-item__meta">
                                <span class="preco">R$ <?php echo number_format((float) str_replace(',', '.', $produto->preco), 2, ',', '.'); ?></span>
                                <span class="badge"><?php echo htmlspecialchars($produto->categoria); ?></span>
                            </div>
                        </div>
                        <div class="product-list-item__actions">
                            <button type="button" class="btn btn--ghost btn-icon" onclick="editarProduto(<?php echo (int) $produto->id; ?>)" title="Editar">✏️</button>
                            <button type="button" class="btn btn--danger btn-icon" onclick="confirmarExclusao(<?php echo (int) $produto->id; ?>, <?php echo json_encode($produto->nome, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE); ?>)" title="Excluir">🗑️</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal-overlay" id="modalConfirm">
    <div class="modal-confirm">
        <h3>Confirmar exclusão</h3>
        <p>Deseja excluir o produto <strong id="produtoNome"></strong>?</p>
        <div class="modal-actions">
            <button type="button" class="btn btn--ghost" onclick="fecharModalConfirm()">Cancelar</button>
            <button type="button" class="btn btn--danger" onclick="excluirProduto()">Excluir</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let produtoIdParaExcluir = null;

function editarUsuario() {
    window.location.href = 'alterarUsuario.php';
}

function abrirModalProdutos() {
    document.getElementById('modalProdutos').classList.add('is-open');
    document.body.style.overflow = 'hidden';
}

function fecharModalProdutos() {
    document.getElementById('modalProdutos').classList.remove('is-open');
    document.body.style.overflow = '';
}

function editarProduto(id) {
    window.location.href = 'alterarProduto.php?id=' + id;
}

function confirmarExclusao(id, nome) {
    produtoIdParaExcluir = id;
    document.getElementById('produtoNome').textContent = nome;
    document.getElementById('modalConfirm').classList.add('is-open');
    document.body.style.overflow = 'hidden';
}

function fecharModalConfirm() {
    document.getElementById('modalConfirm').classList.remove('is-open');
    document.body.style.overflow = '';
    produtoIdParaExcluir = null;
}

function excluirProduto() {
    if (produtoIdParaExcluir) {
        window.location.href = 'deletarProduto.php?id=' + produtoIdParaExcluir;
    }
}

document.getElementById('modalConfirm').addEventListener('click', function (e) {
    if (e.target === this) fecharModalConfirm();
});
document.getElementById('modalProdutos').addEventListener('click', function (e) {
    if (e.target === this) fecharModalProdutos();
});

<?php if (!empty($produtos)): ?>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('graficoPizza').getContext('2d');
    const cores = ['#1a4d2e', '#4f9d69', '#7bc67e', '#c9a227', '#2d6a4f', '#95d5b2', '#40916c', '#b7e4c7'];
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($labelsGrafico, JSON_UNESCAPED_UNICODE); ?>,
            datasets: [{
                data: <?php echo json_encode($dadosGrafico); ?>,
                backgroundColor: cores.slice(0, <?php echo count($labelsGrafico); ?>),
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
});
<?php endif; ?>
</script>

<?php require_once 'includes/footer.php'; ?>
