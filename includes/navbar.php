<?php
$navActive = $navActive ?? '';
$isLoggedIn = isset($_SESSION['id']) && !empty($_SESSION['id']);
$userName = $_SESSION['nome'] ?? '';
?>
<header class="site-header">
    <div class="site-header__inner">
        <a href="index.php" class="brand">
            <img src="assets/logo.svg" alt="EcoMarket" class="brand__logo" width="40" height="40">
            <span class="brand__text">
                <strong>EcoMarket</strong>
                <small>Commodities agrícolas</small>
            </span>
        </a>
        <nav class="site-nav" aria-label="Principal">
            <a href="index.php" class="site-nav__link<?php echo $navActive === 'home' ? ' is-active' : ''; ?>">Vitrine</a>
            <a href="sobre.php" class="site-nav__link<?php echo $navActive === 'sobre' ? ' is-active' : ''; ?>">Sobre</a>
            <a href="contato.php" class="site-nav__link<?php echo $navActive === 'contato' ? ' is-active' : ''; ?>">Contato</a>
            <?php if ($isLoggedIn): ?>
                <a href="dashboard.php" class="site-nav__link<?php echo $navActive === 'dashboard' ? ' is-active' : ''; ?>">Painel</a>
                <span class="site-nav__user"><?php echo htmlspecialchars($userName); ?></span>
                <a href="logout.php" class="btn btn--ghost btn--sm">Sair</a>
            <?php else: ?>
                <a href="login.php" class="btn btn--primary btn--sm<?php echo $navActive === 'login' ? ' is-active' : ''; ?>">Área do produtor</a>
            <?php endif; ?>
        </nav>
        <button type="button" class="site-nav__toggle" aria-label="Abrir menu" data-nav-toggle>
            <span></span><span></span><span></span>
        </button>
    </div>
</header>
