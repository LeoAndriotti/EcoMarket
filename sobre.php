<?php
require_once 'config/bootstrap.php';

$empresa = [
    'nome' => 'EcoMarket',
    'slogan' => 'Commodities agrícolas com transparência e escala',
    'email' => 'contato@ecomarket.com.br',
    'telefone' => '(51) 3000-0000',
];

$valores = [
    ['titulo' => 'Rastreabilidade', 'descricao' => 'Origem clara das commodities e histórico de negociação para compradores e cooperativas.'],
    ['titulo' => 'Rede de produtores', 'descricao' => 'Conectamos fazendas, cooperativas e armazenadores em um único marketplace B2B.'],
    ['titulo' => 'Eficiência', 'descricao' => 'Cotações e publicação de lotes com poucos cliques, reduzindo intermediários.'],
    ['titulo' => 'Sustentabilidade', 'descricao' => 'Incentivo a práticas responsáveis na cadeia do agronegócio brasileiro.'],
];

$pageTitle = 'Sobre — EcoMarket';
$navActive = 'sobre';
$extraStyles = ['styles/pages/sobre.css'];
require_once 'includes/head.php';
require_once 'includes/navbar.php';
?>

<main class="page-wrap">
    <div class="container">
        <section class="about-hero">
            <h1><?php echo htmlspecialchars($empresa['nome']); ?></h1>
            <p><?php echo htmlspecialchars($empresa['slogan']); ?></p>
        </section>

        <p style="max-width:720px;color:var(--color-text-muted);font-size:1.0625rem;line-height:1.7;">
            O EcoMarket nasceu para digitalizar a comercialização de grãos e insumos agrícolas.
            Produtores publicam lotes de soja, trigo, milho, café e outras commodities; compradores
            encontram ofertas atualizadas em uma vitrine profissional e segura.
        </p>

        <div class="values-grid">
            <?php foreach ($valores as $v): ?>
                <article class="value-card card">
                    <h3><?php echo htmlspecialchars($v['titulo']); ?></h3>
                    <p><?php echo htmlspecialchars($v['descricao']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="about-stats">
            <div class="about-stat"><strong>17+</strong><span>Commodities na vitrine</span></div>
            <div class="about-stat"><strong>5</strong><span>Categorias agrícolas</span></div>
            <div class="about-stat"><strong>B2B</strong><span>Foco produtor e comprador</span></div>
        </div>

        <section style="margin-top:2.5rem;text-align:center;">
            <p style="font-weight:600;color:var(--color-primary);margin-bottom:1rem;">Desenvolvido por Leonardo Andriotti</p>
            <?php $socialLinksClass = 'social-links--light'; require __DIR__ . '/includes/social-links.php'; ?>
            <p style="margin-top:1.5rem;">
                <a href="index.php" class="btn btn--primary">Ver vitrine</a>
                <a href="cadastrarUsuario.php" class="btn btn--ghost" style="margin-left:0.5rem;">Cadastrar como produtor</a>
            </p>
        </section>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
