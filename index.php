<?php
require_once 'config/bootstrap.php';
require_once 'classes/Produto.php';
require_once 'classes/Categoria.php';

$listaCategorias = Categoria::buscarTodas();

if (empty($listaCategorias)) {
    $conn = DataBase::getConnection();
    $categoriasPadrao = ['Grãos', 'Oleaginosas', 'Leguminosas', 'Fibra e Café', 'Sementes'];
    foreach ($categoriasPadrao as $categoria) {
        $stmt = $conn->prepare("INSERT INTO tbCategorias (nome) VALUES (?)");
        $stmt->execute([$categoria]);
    }
    $listaCategorias = Categoria::buscarTodas();
}

$categoriaSelecionada = isset($_GET['categoria']) ? $_GET['categoria'] : '';
if ($categoriaSelecionada) {
    $produtos = Produto::buscarPorCategoria($categoriaSelecionada);
} else {
    $produtos = Produto::buscarTodos();
}

$pageTitle = 'EcoMarket — Marketplace de commodities agrícolas';
$navActive = 'home';
$extraStyles = ['styles/pages/index.css'];
require_once 'includes/head.php';
require_once 'includes/navbar.php';
?>

<main class="page-wrap">
    <div class="container">
        <section class="hero">
            <span class="hero__badge">Agronegócio B2B</span>
            <h1>Negocie grãos e commodities com produtores verificados</h1>
            <p>Soja, trigo, milho, café e insumos agrícolas em um só lugar. Conectamos cooperativas, fazendas e compradores com transparência.</p>
            <a href="#vitrine" class="btn btn--accent btn--lg">Explorar ofertas</a>
        </section>

        <div class="section-header" id="vitrine">
            <h2>Vitrine de commodities</h2>
            <form class="filter-bar" method="get">
                <label for="categoria">Categoria</label>
                <select name="categoria" id="categoria" class="form-control" onchange="this.form.submit()">
                    <option value="">Todas</option>
                    <?php foreach ($listaCategorias as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat->nome); ?>" <?php if ($cat->nome === $categoriaSelecionada) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($cat->nome); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

        <?php if (empty($produtos)): ?>
            <div class="alert alert--error">Nenhum produto encontrado nesta categoria.</div>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($produtos as $produto): ?>
                    <article class="card product-card">
                        <div class="product-card__media">
                            <img src="<?php echo htmlspecialchars($produto->imagem ?: 'uploads/placeholder.svg'); ?>"
                                 alt="<?php echo htmlspecialchars($produto->nome); ?>">
                        </div>
                        <div class="product-card__body">
                            <h3 class="product-card__title"><?php echo htmlspecialchars($produto->nome); ?></h3>
                            <p class="product-card__desc"><?php echo htmlspecialchars($produto->descricao); ?></p>
                            <div class="product-card__price">
                                R$ <?php echo number_format((float) str_replace(',', '.', $produto->preco), 2, ',', '.'); ?>
                            </div>
                            <div class="product-card__footer">
                                <span class="badge"><?php echo htmlspecialchars($produto->categoria); ?></span>
                                <button type="button" class="btn btn--primary btn--sm"
                                    onclick='abrirModalProduto(<?php echo json_encode($produto, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE); ?>)'>
                                    Ver detalhes
                                </button>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<div class="modal-overlay" id="modalFormulario">
    <div class="modal">
        <button type="button" class="modal__close" onclick="fecharModal('modalFormulario')" aria-label="Fechar">&times;</button>
        <h3 class="modal__title">Fale conosco</h3>
        <form id="formContato">
            <div class="form-group">
                <label for="nome">Nome completo</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="tel" id="telefone" name="telefone">
            </div>
            <div class="form-group">
                <label for="assunto">Assunto</label>
                <select id="assunto" name="assunto" required>
                    <option value="">Selecione</option>
                    <option value="cotacao">Cotação de commodity</option>
                    <option value="parceria">Parceria comercial</option>
                    <option value="suporte">Suporte</option>
                    <option value="outro">Outro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="mensagem">Mensagem</label>
                <textarea id="mensagem" name="mensagem" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn--primary btn--block">Enviar mensagem</button>
        </form>
    </div>
</div>

<div class="modal-overlay" id="modalProduto">
    <div class="modal">
        <button type="button" class="modal__close" onclick="fecharModal('modalProduto')" aria-label="Fechar">&times;</button>
        <h3 class="modal__title" id="produtoTitulo">Produto</h3>
        <div id="produtoConteudo"></div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
