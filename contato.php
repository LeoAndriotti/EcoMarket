<?php
require_once 'config/bootstrap.php';

$pageTitle = 'Contato — EcoMarket';
$navActive = 'contato';
require_once 'includes/head.php';
require_once 'includes/navbar.php';
?>

<main class="page-wrap">
    <div class="container container--narrow">
        <div class="form-card">
            <h1>Fale conosco</h1>
            <p class="subtitle">Dúvidas sobre cotações, parcerias ou suporte à plataforma</p>
            <form onsubmit="event.preventDefault(); alert('Mensagem registrada! Em breve entraremos em contato.');">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <div class="form-group">
                    <label for="mensagem">Mensagem</label>
                    <textarea class="form-control" id="mensagem" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn--primary btn--block">Enviar</button>
            </form>
            <div style="margin-top:1.5rem;padding-top:1.5rem;border-top:1px solid var(--color-border);font-size:0.9rem;color:var(--color-text-muted);">
                <p><strong>E-mail:</strong> contato@ecomarket.com.br</p>
                <p><strong>Telefone:</strong> (51) 3000-0000</p>
            </div>
            <div style="margin-top:1.5rem;">
                <p style="font-weight:600;color:var(--color-primary);margin-bottom:0.75rem;font-size:0.9rem;">Leonardo Andriotti — Desenvolvedor</p>
                <?php $socialLinksClass = 'social-links--light'; require __DIR__ . '/includes/social-links.php'; ?>
            </div>
            <p style="text-align:center;margin-top:1.25rem;"><a href="index.php">← Voltar à vitrine</a></p>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
